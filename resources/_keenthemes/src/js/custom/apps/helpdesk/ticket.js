"use strict";

// Class definition
var KTTicket = function () {
    // Shared variables
    var tableTicket;
    var dtTicket;
    var dtButtons;
    var form, categoryField;
    var submitButton, cancelButton;
    var validator;

    // Private functions
    var initDatatable = function () {

        dtButtons = ['copy', 'reload', 'print'];

        if(canCreateTicket){
            dtButtons.push({
                text: 'New Ticket',
                action: function (e, dt, node, config) {
                    $('#kt_docs_card_ticket_list').collapse('hide');
                    $('#kt_docs_card_ticket_new').collapse('show');
                }
            });

        }


        dtTicket = $("#ticketTable").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[5, 'desc']],
            stateSave: true,
            ajax: {
                url: "/apps/helpdesk/api/ticket",
                dataSrc: 'tickets'
            },
            columns: [
                {
                    targets: 0,
                    data: null,
                    render: function (data, type, row, meta) {
                        // 'meta.row' contains the row number
                        return meta.row + 1;
                    },
                },
                { data: 'user_name' },
                { data: 'subject' },
                { data: 'description' },
                { data: 'origin_unit' },
                { data: 'source_report' },
                { data: 'priority' },
                {
                    data: 'issue_category',
                    render: function (data, type, row) {
                        // Handle array values
                        if (Array.isArray(data)) {
                            return data.join(', '); // Join array values with a comma and space
                        }

                        return data; // If not an array, return the original value
                    }
                },
                {
                    targets: 10,
                    data: 'status',
                    render: function (data, type, row) {
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
                    render: function (data, type, row) {
                            if(data){
                                // If work_order exists, show "View" button
                            return '<span class="badge badge-primary"><a href="/apps/helpdesk/print/wo/' + row.work_order + '" target="_blank" class="text-info view-work-order" data-id="' + row.id + '">View</a></span>';
                            }else{
                                if(isSupervisor){
                                    // If work_order does not exist, show "Generate Work Order" button
                            return '<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order" class="generate-work-order"  data-id="' + row.id + '">Generate Work Order</a>';
                                }else{
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
            buttons: dtButtons,
            // Use the passed data

        });



        tableTicket = dtTicket.$;
        // Refresh the DataTable to reflect the changes
        dtTicket.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dtTicket.on('draw', function () {
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
                const ticketSubject = parent.querySelectorAll('td')[2].innerText;
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

                            // Swal.fire({
                            //     text: "You have deleted " + ticketSubject + "!.",
                            //     icon: "success",
                            //     buttonsStyling: false,
                            //     confirmButtonText: "Ok, got it!",
                            //     customClass: {
                            //         confirmButton: "btn fw-bold btn-primary",
                            //     }
                            // }).then(function () {
                            //     // delete row data from server and re-draw datatable
                            //     dtTicket.draw();
                            // });
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
                    'kt_td_picker_time_only_input': {
                        validators: {
                            notEmpty: {
                                message: 'Report Time is required'
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
                    'unit-dropdown': {
                        validators: {
                            notEmpty: {
                                message: 'Unit is required'
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
                    'issuecategory[]': {
                        validators: {
                            choice: {
                                min: 1,
                                max: 5,
                                message: 'Please check minimum 1 category'
                            }
                        }
                    },
                    'category-dropdown': {
                        validators: {
                            callback: {
                                message: 'Please choose 2-4 color you like most',
                                callback: function (input) {
                                    // Get the selected options
                                    const options = categoryField.select2('data');
                                    return options != null && options.length >= 1;
                                },
                            },
                        }
                    }
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

        // Add a click event listener to the "Cancel" button
        cancelButton.addEventListener('click', function () {
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


    // Handle form ajax
    var handleFormAjax = function (e) {
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
                    'email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'The value is not a valid email address',
                            },
                            notEmpty: {
                                message: 'Email address is required'
                            }
                        }
                    },
                    'toc': {
                        validators: {
                            notEmpty: {
                                message: 'You must accept the terms and conditions'
                            }
                        }
                    }
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
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // validator.revalidateField('password');

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;


                    // Check axios library docs: https://axios-http.com/docs/intro
                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                        if (response) {
                            form.reset();

                            const redirectUrl = form.getAttribute('data-kt-redirect-url');

                            if (redirectUrl) {
                                location.href = redirectUrl;
                            }
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
                    }).catch(function (error) {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }).then(() => {
                        // Hide loading indication
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;
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

    var isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            initDatatable();
            handleDeleteRows();
            // Elements
            form = document.querySelector('#kt_new_ticket_form');
            submitButton = document.querySelector('#kt_new_ticket_submit');
            cancelButton = document.querySelector('#kt_new_ticket_cancel');
            categoryField = document.querySelector('[name="category-dropdown"]');

            if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                handleFormAjax();
            } else {
                handleForm();
            }
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTTicket.init();
});
