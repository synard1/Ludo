"use strict";

// Class definition
var KTTicket = function () {
    // Shared variables
    var tableTicket, tableStatus, ticketTitle;
    var dtTicket, dtStatus;
    var dtButtons;
    var form, formWO, formNotes, formStatus, formHistory;
    var submitButton, xButton, submitButtonWO, submitButtonNotes, submitButtonStatus, closeButtonHistory, newTicketButton;
    var validator, validatorWO, validatorNotes, validatorStatus;
    var checkSLA;

    // Private functions
    var initDatatableStatusHistory = function(id) {
        dtButtons = ['reload', 'print'];

        $.fn.dataTable.ext.buttons.reload = {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                $('#historyTable').DataTable().ajax.reload();
            }
        };

        dtStatus = $("#historyTable").DataTable({    
            ajax: {
                url: "/apps/helpdesk/api/ticket/statushistory",
                data: {
                    ticket_id: id,
                },
            },
            columns: [{
                    targets: 0,
                    data: null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' contains the row number
                        return meta.row + 1;
                    },
                },
                {
                    data: 'status'
                },
                {
                    data: 'reason'
                },
                {
                    data: 'created_by',
                },
                {
                    data: 'created_at',
                    title: 'Created Date',
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Format the date using moment.js
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }
                        return data; // For sorting and other types
                    }
                },
                
            ],
            dom: 'Bfrtip',
            buttons: dtButtons,
            
            // Use the passed data
        });

        tableTicket = dtStatus.$;
        // Refresh the DataTable to reflect the changes
        dtStatus.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dtStatus.on('draw', function() {
            KTMenu.init(); // reinit KTMenu instances
        });

        
    }

    // Delete ticket
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');
        // const deleteButtons = document.querySelector('#delete_row');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get subject name
                const ticketSubject = parent.querySelectorAll('td')[1].innerText;
                const ticketId = $(this).data('id');
                // console.log(ticketId);

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + ticketSubject + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        // Simulate delete request -- for demo purpose only
                        Swal.fire({
                            text: "Deleting " + ticketSubject,
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            $.ajax({
                                url: '/apps/helpdesk/api/deleteTicket/' + ticketId,
                                type: 'DELETE',
                                success: function(response) {
                                    // Refresh the DataTable or remove the row from the table
                                    // depending on your implementation
                                    swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn font-weight-bold btn-light-primary"
                                        }
                                    }).then(function(){
                                        dtTicket.draw();
                                    });
                                },
                                error: function (error) {
                                    let errorMessage = "Sorry, looks like there are some errors detected, please try again.";

                                    if (error.responseJSON && error.responseJSON.message) {
                                        errorMessage = error.responseJSON.message;
                                    }

                                    Swal.fire({
                                        text: errorMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });

                                    console.error('Error deleting ticket:', error);
                                }
                            });
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: ticketSubject + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Handle form Work Order
    var handleFormWO = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorWO = FormValidation.formValidation(
            formWO,
            {
                fields: {
                    'subject_wo': {
                        validators: {
                            notEmpty: {
                                message: 'Subject is required'
                            }
                        }
                    },
                    'due_date': {
                        validators: {
                            notEmpty: {
                                message: 'Due Date is required',
                                // Conditionally enable or disable the validator based on slaExists
                                enabled: !checkSLA
                            }
                        }
                    },
                    'sla': {
                        validators: {
                            notEmpty: {
                                message: 'SLA is required',
                                // Conditionally enable or disable the validator based on slaExists
                                enabled: checkSLA
                            }
                        }
                    },
                    'description_wo': {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
                            }
                        }
                    },
                    'staffSelect': {
                        validators: {
                            notEmpty: {
                                message: 'Please Assign A Staff'
                            }
                        }
                    },
                    'priority': {
                        validators: {
                            notEmpty: {
                                message: 'Priority is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );

        // Handle form submit
        submitButtonWO.addEventListener('click', function (e) {
            e.preventDefault();

            validatorWO.validate().then(function (status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitButtonWO.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButtonWO.disabled = true;

                    $.ajax({
                        url: '/apps/helpdesk/api/workorder',
                        type: 'POST',
                        data: {
                            ticket_id: $('#ticket_id').val(),
                            subject: $('#subject_wo').val(),
                            description: $('#description_wo').val(),
                            due_date: $('#due_date').val(),
                            sla: $('#sla').val(),
                            staff: $('#staffSelect').val(),
                            priority: $('#priority').val(),
                        },
                        success: function (response) {
                            // alert(response.message);
                            // Hide loading indication
                            submitButtonWO.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonWO.disabled = false;

                            // Reset the form and Select2 tags after submission (if needed)
                            $('#kt_modal_new_work_order_form')[0].reset();
                            // staffSelect.val(null).trigger('change');

                            // Close the modal
                            $('#kt_modal_work_order').modal('hide');

                            swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                // toggleChangeEmail();
                                // Hide loading indication
                                submitButtonWO.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonWO.disabled = false;

                                $('#tickets-table').DataTable().ajax.reload();

                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButtonWO.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonWO.disabled = false;

                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });

                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });

        

        

        $('#tickets-table').on('click', '.generate-work-order', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');
            // Implement logic to handle "Generate Work Order" button click
            // console.log('Generate work order for ID: ' + id);
            // Get the data-id attribute value from the clicked link
            var rowId = $(this).data('id');

            fetchStaffData();

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#ticket_id').val(rowId);
            $('#subject_wo').val(title);
        });

        var options = {
            selector: "#description_wo",
            height: "480"
        };

        if (KTThemeMode.getMode() === "dark") {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);

    }

    // Handle form Work Order
    var handleFormNotes = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorNotes = FormValidation.formValidation(
            formNotes,
            {
                fields: {
                    'notes': {
                        validators: {
                            notEmpty: {
                                message: 'Note is required'
                            }
                        }
                    },
                    'category[]': {
                        validators: {
                            choice: {
                                min: 1,
                                max: 5,
                                message: 'Please check minimum 1 category'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );

        // Handle form submit
        submitButtonNotes.addEventListener('click', function (e) {
            e.preventDefault();

            validatorNotes.validate().then(function (status) {
                if (status == 'Valid') {

                    // Get the data-id attribute value from the clicked row
                    var rowId = $(this).closest('tr').data('id');
                    // Get the selected issuecategory options
                    var categoryOptions = [];
                        $("input[name='category[]']:checked").each(function () {
                            categoryOptions.push($(this).val());
                        });

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitButtonNotes.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButtonNotes.disabled = true;

                    $.ajax({
                        url: '/apps/helpdesk/api/workorder/notes',
                        type: 'POST',
                        data: {
                            ticket_id: $('#ticket_id').val(),
                            notes: $('#notes').val(),
                            category: categoryOptions,
                        },
                        success: function (response) {
                            // alert(response.message);
                            // Hide loading indication
                            submitButtonNotes.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonNotes.disabled = false;

                            // Close the modal
                            $('#kt_modal_work_order_note').modal('hide');

                            swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                // Hide loading indication
                                submitButtonNotes.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonNotes.disabled = false;

                                formNotes.reset();

                                $('#tickets-table').DataTable().ajax.reload();

                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButtonNotes.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonNotes.disabled = false;

                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });

                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });

        
    }
    // Handle form Work Order
    var handleFormStatus = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorStatus = FormValidation.formValidation(
            formStatus,
            {
                fields: {
                    'status': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    'reason': {
                        validators: {
                            notEmpty: {
                                message: 'Reason is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );

        // Handle form submit
        submitButtonStatus.addEventListener('click', function (e) {
            e.preventDefault();

            validatorStatus.validate().then(function (status) {
                if (status == 'Valid') {

                    // Get the data-id attribute value from the clicked row
                    var rowId = $(this).closest('tr').data('id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitButtonStatus.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButtonStatus.disabled = true;

                    $.ajax({
                        url: '/apps/helpdesk/api/ticket/status',
                        type: 'POST',
                        data: {
                            ticket_id: $('#ticket_id').val(),
                            status: $('#status').val(),
                            reason: $('#reason').val(),
                        },
                        success: function (response) {
                            // Hide loading indication
                            submitButtonStatus.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonStatus.disabled = false;

                            // Close the modal
                            $('#kt_modal_change_status').modal('hide');

                            swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                // Hide loading indication
                                submitButtonStatus.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonStatus.disabled = false;

                                formStatus.reset();

                                $('#tickets-table').DataTable().ajax.reload();

                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButtonStatus.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonStatus.disabled = false;

                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });

                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });

        $('#tickets-table').on('click', '.status-change', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');

            $('#ticket_id').val(id);
            $('#old_status').val(status);
        });

        $('#tickets-table').on('click', '.delete-row', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // console.log('delete row click!');

            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const ticketSubject = parent.querySelectorAll('td')[1].innerText;
            const ticketId = $(this).data('id');
            // console.log(ticketId +' '+ ticketSubject);
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ ticketSubject +`</b> ?`,
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    // Simulate delete request -- for demo purpose only
                    Swal.fire({
                        html: `Deleting  <b>`+ ticketSubject +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            url: '/apps/helpdesk/api/deleteTicket/' + ticketId,
                            type: 'DELETE',
                            success: function(response) {
                                // Refresh the DataTable or remove the row from the table
                                // depending on your implementation
                                swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function(){
                                    $('#tickets-table').DataTable().ajax.reload();
                                });
                            },
                            error: function (error) {
                                let errorMessage = "Sorry, looks like there are some errors detected, please try again.";

                                if (error.responseJSON && error.responseJSON.message) {
                                    errorMessage = error.responseJSON.message;
                                }

                                Swal.fire({
                                    text: errorMessage,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });

                                console.error('Error deleting ticket:', error);
                            }
                        });
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        html: `<b>`+ ticketSubject +`</b> was not deleted.`,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });

    }

    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'service': {
                        validators: {
                            notEmpty: {
                                message: 'Service is required'
                            }
                        }
                    },
                    'subject': {
                        validators: {
                            notEmpty: {
                                message: 'Subject is required'
                            }
                        }
                    },
                    'report_time': {
                        validators: {
                            notEmpty: {
                                message: 'Report Time is required'
                            }
                        }
                    },
                    'respond_date': {
                        validators: {
                            notEmpty: {
                                message: 'Respond Time is required'
                            }
                        }
                    },
                    'sourcesReport': {
                        validators: {
                            notEmpty: {
                                message: 'Sources of Report is required'
                            }
                        }
                    },
                    'unit-dropdown': {
                        validators: {
                            notEmpty: {
                                message: 'Unit is required'
                            }
                        }
                    },
                    'issuecategory[]': {
                        validators: {
                            choice: {
                                min: 1,
                                max: 5,
                                message: 'Please check minimum 1 category'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
                }
            }
        );

        // // Add a click event listener to the "Cancel" button
        xButton.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset();
            // Close kt_docs_card_ticket_new
            $('#kt_docs_card_ticket_new').collapse('hide');
            // Show kt_docs_card_ticket_list
            $('#kt_docs_card_ticket_list').collapse('show');
            $("#tickets-table").DataTable().ajax.reload(null, false); 
        });

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    var formData = new FormData(document.getElementById('kt_new_ticket_form'));

                    // Check if formData has the 'ticket_id' input
                    if (formData.has('ticket_id')) {
                        // console.log("FormData has 'ticket_id' input");
                        // Get the selected issuecategory options
                        var issuecategoryOptions = [];
                        $("input[name='issuecategory[]']:checked").each(function () {
                            issuecategoryOptions.push($(this).val());
                        });
                        
                    } else {
                        // console.log("FormData does not have 'ticket_id' input");

                        // Get the selected issuecategory options
                        var issuecategoryOptions = [];
                        $("input[name='issuecategory[]']:checked").each(function () {
                            issuecategoryOptions.push($(this).val());
                        });
                    }

                    

                    // Append issue_category to the formData
                    // formData.append('issue_category', issuecategoryOptions);

                    $.ajax({
                        url: '/apps/helpdesk/api/ticket',
                        type: 'POST',
                        data: formData,
                        processData: false,  // Important: Don't process the data
                        contentType: false,  // Important: Set content type to false
                        // data: {
                        //     subject: $('#subject').val(),
                        //     description: $('#description').val(),
                        //     report_time: $('#report_time').val(),
                        //     respond_date: $('#respond_date').val(),
                        //     reporter_name: $('#reporter-dropdown').val(),
                        //     origin_unit: $('#unit-dropdown').val(),
                        //     issue_category: issuecategoryOptions,
                        //     source_report: $('#sourcesReport').val(),
                        //     // Include other fields here
                        //     // _token: '{{ csrf_token() }}', // CSRF token for Laravel
                        // },
                        success: function (response) {
                            // alert(response.message);
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function(){
                                // settingCompanyForm.reset();
                                // validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                                // toggleChangeEmail();
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                                $('#kt_docs_card_ticket_list').collapse('show');
                                $('#kt_docs_card_ticket_new').collapse('hide');
                                // dtTicket.ajax.reload();
                                $('#tickets-table').DataTable().ajax.reload();
                                form.reset();
                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });

                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });

        // Handle form close
        closeButtonHistory.addEventListener('click', function (e) {
            e.preventDefault();
            $("#historyTable").DataTable().destroy();
        });

        $('#tickets-table').on('click', '.edit-ticket', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            ticketTitle.innerText = 'Edit Ticket';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const ticketSubject = parent.querySelectorAll('td')[1].innerText;
            const ticketId = $(this).data('id');
            // console.log(ticketId +' '+ ticketSubject);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ ticketSubject +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Close kt_docs_card_ticket_new
                $('#kt_docs_card_ticket_new').collapse('show');
                // Show kt_docs_card_ticket_list
                $('#kt_docs_card_ticket_list').collapse('hide');

                $.ajax({
                    url: '/apps/helpdesk/api/ticket',
                    type: 'GET',
                    data: {
                        ticket_id: ticketId,
                    },
                    success: function(response) {
                        $('#subject').val(response.data.subject);
                        $('#description').val(response.data.description);
                        // $('#report_time').val(response.data.report_time);
                        // $('#respond_date').val(response.data.response_time);

                        // Find the input element by its id
                        var subjectInput = document.getElementById('subject');
                        subjectInput.setAttribute('readonly', true);

                        // Format date and set values for report_time and respond_date
                        $('#report_time').val(formatDateTime(response.data.report_time));
                        $('#respond_date').val(formatDateTime(response.data.response_time));

                        // Loop through the issue_category array and check the corresponding checkboxes
                        // var categoryData = response.data.issue_category;
                        response.data.issue_category.forEach(function(category) {
                            $('input[name="issuecategory[]"][value="' + category + '"]').prop('checked', true);
                        });


                        // $('#unit-dropdown').val(response.data.origin_unit);

                        // Auto-select the unit-dropdown based on response.data.origin_unit
                        selectUnit(response.data.origin_unit);
                        selectSource(response.data.source_report);
                        selectReporter(response.data.reporter_name);

                        // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "ticket_id";
                        hiddenInput.name = "ticket_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.data.id;
                        hiddenInput.readOnly = true;

                        // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_new_ticket_form").appendChild(hiddenInput);
                    },
                    error: function (error) {
                        let errorMessage = "Sorry, looks like there are some errors detected, please try again.";

                        if (error.responseJSON && error.responseJSON.message) {
                            errorMessage = error.responseJSON.message;
                        }

                        Swal.fire({
                            text: errorMessage,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });

                        console.error('Error deleting ticket:', error);
                    }
                });
            });
        });

        $('#tickets-table').on('click', '.status-history', function() {
            var id = $(this).data('id');
            initDatatableStatusHistory(id);
        });

        // Add a click event listener to the "New Ticket" button
        newTicketButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_ticket_form');
            form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            ticketTitle.innerText = 'New Ticket';

            // Find the input element by its id
            var subjectInput = document.getElementById('subject');
            subjectInput.removeAttribute('readonly');


            // Close kt_docs_card_ticket_new
            $('#kt_docs_card_ticket_new').collapse('show');
            // Show kt_docs_card_ticket_list
            $('#kt_docs_card_ticket_list').collapse('hide');
        });

    }

    // Function to fetch staff data and populate the dropdown
    var fetchStaffData = function (e) {
    // function fetchStaffData() {
        // Replace this URL with your actual API endpoint
        const apiUrl = '/apps/helpdesk/api/workorder/staff';

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Get the Select2 instance
                const staffSelect = $('#staffSelect');

                // Clear existing options
                staffSelect.empty();

                // Add new options based on the fetched data
                data.forEach(staff => {
                    const option = new Option(staff, staff);
                    staffSelect.append(option);
                });

                // Trigger Select2 to update the UI
                staffSelect.trigger('change');
            })
            .catch(error => {
                console.error('Fetch error:', error.message);
            });
    }


    var getTicket = function (id){
        return new Promise(function(resolve, reject) {
            try {
                $.ajax({
                    url: '/apps/helpdesk/api/ticket',
                    type: 'GET',
                    data: {
                        ticket_id: id,
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function (error) {
                        reject(error);
                    }
                });
            } catch (error) {
                reject(error);
            }
        });
    }

    // Implement logic to handle "Generate Notes" button click
    $('#tickets-table').on('click', '.generate-notes', function() {
        var id = $(this).data('id');
        getTicket(id)
            .then(function(hasil) {
                // console.log("Hasil:", hasil);

                $('#notes').val(hasil.data.notes);

                hasil.data.issue_category.forEach(function(category) {
                    $('input[name="category[]"][value="' + category + '"]').prop('checked', true);
                });
            })
            .catch(function(error) {
                console.error("Error:", error);
            });
        
        // Assuming you want to set the data-id value to an input field in the modal form
        $('#ticket_id').val(id);
        
    });

    var isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }

    

    $("#report_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
        minDate: getSevenDaysAgo(),
        minuteIncrement: 1
    });

    $("#respond_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
        minDate: getSevenDaysAgo(),
        minuteIncrement: 1
    });

    // Flatpickr configuration
    $("#due_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: getLastDayOfMonth(),
        minDate: getSevenDaysAgo(),
        minuteIncrement: 1
    });

    // Function to format date and time (assuming response.data.report_time and response.data.response_time are in the format 'Y-m-d H:i:s')
    function formatDateTime(dateTimeString) {
        // return moment(dateTimeString, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm');
        // Format the date using moment.js
        return moment(dateTimeString).format('YYYY-MM-DD HH:mm:ss');
    }

    // Function to auto-select unit in dropdown
    function selectUnit(selectedUnit) {
        $('#unit-dropdown').val(selectedUnit).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    // Function to auto-select unit in dropdown
    function selectReporter(selectedUser) {
        $('#reporter-dropdown').val(selectedUser).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    // Function to auto-select unit in dropdown
    function selectSource(selectedSource) {
        $('#sourcesReport').val(selectedSource).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    // Get the last day of the current month
    function getLastDayOfMonth() {
        var today = new Date();
        var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        return lastDay;
    }

    // Get the date exactly 7 days ago
    function getSevenDaysAgo() {
        var today = new Date();
        var sevenDaysAgo = new Date(today);
        sevenDaysAgo.setDate(today.getDate() - 7);
        return sevenDaysAgo;
    }

    // Initialize Select2 with tag support
    $('#staffSelect').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function(params) {
            return {
                id: params.term,
                text: params.term,
                newTag: true
            };
        }
    });


    // Public functions
    return {
        // Initialization
        init: function () {
            // initDatatable();
            // initDatatableStatusHistory();
            handleDeleteRows();
            fetchStaffData();
            // Elements
            form = document.querySelector('#kt_new_ticket_form');
            submitButton = document.querySelector('#kt_new_ticket_submit');
            xButton = document.querySelector('#kt_new_ticket_cancel');
            newTicketButton = document.querySelector('#kt_new_ticket');
            ticketTitle = document.getElementById('ticketTitle');

            formWO = document.querySelector('#kt_modal_new_work_order_form');
            submitButtonWO = document.querySelector('#kt_modal_new_work_order_submit');

            formNotes = document.querySelector('#kt_modal_work_order_note_form');
            submitButtonNotes = document.querySelector('#kt_modal_work_order_note_submit');

            formStatus = document.querySelector('#kt_modal_change_status_form');
            submitButtonStatus = document.querySelector('#kt_modal_change_status_submit');

            formHistory = document.querySelector('#kt_modal_change_status_form');
            closeButtonHistory = document.querySelector('#kt_modal_history_status_close');

            if(slaExist){
                checkSLA = true;
            }else{
                checkSLA = false;
            }

            if(isSupervisor){
                if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                    handleForm();
                } else {
                    handleForm();
                }
            }

            if (isValidUrl(submitButtonWO.closest('form').getAttribute('action'))) {
                handleFormWO();
            } else {
                handleFormWO();
            }

            if (isValidUrl(submitButtonNotes.closest('form').getAttribute('action'))) {
                handleFormNotes();
            } else {
                handleFormNotes();
            }

            if (isValidUrl(submitButtonStatus.closest('form').getAttribute('action'))) {
                handleFormStatus();
            } else {
                handleFormStatus();
            }
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTTicket.init();
});
