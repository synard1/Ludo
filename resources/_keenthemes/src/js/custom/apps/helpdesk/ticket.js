"use strict";

// Class definition
var KTTicket = function () {
    // Shared variables
    var tableTicket;
    var dtTicket;
    var dtButtons;
    var form, formWO, formNotes, categoryField;
    var submitButton, xButton, submitButtonWO, submitButtonNotes;
    var validator, validatorWO, validatorNotes;

    // Private functions
    var initDatatable = function() {
        dtButtons = ['reload', 'print',
        {
            extend: 'colvis'
        }];

        $.fn.dataTable.ext.buttons.reload = {
            text: 'Reload',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            }
        };
        
        if (canCreateTicket) {
            dtButtons.push({
                text: 'New Ticket',
                action: function(e, dt, node, config) {
                    $('#kt_docs_card_ticket_list').collapse('hide');
                    $('#kt_docs_card_ticket_new').collapse('show');
                }
            });
        }

        dtTicket = $("#ticketTable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "/apps/helpdesk/api/ticket",
                dataSrc: 'tickets'
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
                    data: 'subject'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'description'
                },
                {
                    data: 'origin_unit'
                },
                {
                    data: 'source_report'
                },
                {
                    data: 'priority'
                },
                {
                    data: 'issue_category',
                    render: function(data, type, row) {
                        // Handle array values
                        if (Array.isArray(data)) {
                            return data.join(
                            ', '); // Join array values with a comma and space
                        }

                        return data; // If not an array, return the original value
                    }
                },
                {
                    targets: 10,
                    data: 'status',
                    render: function(data, type, row) {
                        switch (data.toLowerCase()) {
                            case 'open':
                                return '<span class="badge badge-success">Open</span>';
                            case 'pending':
                                return '<span class="badge badge-warning">Pending</span>';
                            case 'closed':
                                return '<span class="badge badge-secondary">Closed</span>';
                            case 'resolved':
                                return '<span class="badge badge-primary">Resolved</span>';
                            default:
                                return data;
                        }
                    },
                },
                {
                    targets: 12,
                    data: 'work_order', // Assuming the attribute is named 'work_order'
                    render: function(data, type, row) {
                        if (data) {
                            // If work_order exists, show "View" button
                            return '<span class="badge badge-primary"><a href="/apps/helpdesk/print/wo/' +
                                row.work_order +
                                '" target="_blank" class="text-info view-work-order" data-id="' +
                                row.id + '">View</a></span>';
                        } else {
                            if (isSupervisor) {
                                // If work_order does not exist, show "Generate Work Order" button
                                return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' + row.id + '" data-report-time="' + row.report_time + '">Generate Work Order</a>';
                            } else {
                                return '<a href="#">N/A</a>';
                            }
                        }
                    },
                },
                {
                    class: 'text-end',
                    orderable: false,
                    data: 'actionButtons',
                },
            ],
            dom: 'Bfrtip',
            columnDefs: [
                {
                    targets: 3,
                    visible: false
                }
            ],
            buttons: dtButtons,
            
            // Use the passed data
        });

        tableTicket = dtTicket.$;
        // Refresh the DataTable to reflect the changes
        dtTicket.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dtTicket.on('draw', function() {
            handleDeleteRows();
            KTMenu.init(); // reinit KTMenu instances
        });
    }

    // Delete ticket
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get subject name
                const ticketSubject = parent.querySelectorAll('td')[1].innerText;
                const ticketId = $(this).data('id');
                console.log(ticketId);

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
                                message: 'Due Date is required'
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

                                $('#ticketTable').DataTable().ajax.reload();

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

        $('#ticketTable').on('click', '.generate-work-order', function() {
            var id = $(this).data('id');
            // Implement logic to handle "Generate Work Order" button click
            console.log('Generate work order for ID: ' + id);
            // Get the data-id attribute value from the clicked link
            var rowId = $(this).data('id');

            fetchStaffData();

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#ticket_id').val(rowId);
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

                                $('#ticketTable').DataTable().ajax.reload();

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

        $('#ticketTable').on('click', '.generate-notes', function() {
            var id = $(this).data('id');
            // Implement logic to handle "Generate Notes" button click
            console.log('Generate Notes for ID: ' + id);
            // Get the data-id attribute value from the clicked link
            var rowId = $(this).data('id');

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#ticket_id').val(rowId);
        });

    }

    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
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
            dtTicket.ajax.reload();
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

                    // Get the selected issuecategory options
                    var issuecategoryOptions = [];
                    $("input[name='issuecategory[]']:checked").each(function () {
                        issuecategoryOptions.push($(this).val());
                    });

                    $.ajax({
                        url: '/apps/helpdesk/api/ticket',
                        type: 'POST',
                        data: {
                            subject: $('#subject').val(),
                            description: $('#description').val(),
                            report_time: $('#report_time').val(),
                            reporter_name: $('#reporter-dropdown').val(),
                            origin_unit: $('#unit-dropdown').val(),
                            issue_category: issuecategoryOptions,
                            source_report: $('#sourcesReport').val(),
                            // Include other fields here
                            // _token: '{{ csrf_token() }}', // CSRF token for Laravel
                        },
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
                                dtTicket.ajax.reload();
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
    });

    $("#due_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
    });

    

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
            initDatatable();
            handleDeleteRows();
            fetchStaffData();
            // Elements
            form = document.querySelector('#kt_new_ticket_form');
            submitButton = document.querySelector('#kt_new_ticket_submit');
            xButton = document.querySelector('#kt_new_ticket_cancel');

            formWO = document.querySelector('#kt_modal_new_work_order_form');
            submitButtonWO = document.querySelector('#kt_modal_new_work_order_submit');

            formNotes = document.querySelector('#kt_modal_work_order_note_form');
            submitButtonNotes = document.querySelector('#kt_modal_work_order_note_submit');

            if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                handleForm();
            } else {
                handleForm();
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
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTTicket.init();
});
