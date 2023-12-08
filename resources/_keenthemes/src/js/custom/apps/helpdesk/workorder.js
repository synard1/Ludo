"use strict";

// Class definition
var KTWorkorder = function () {
    // Shared variables
    var tableWorkorder;
    var dtWorkorder;
    var dtButtons;
    var form;
    var submitButton, cancelButton;
    var validator;

    // Private functions
    var initDatatable = function () {

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

        dtWorkorder = $("#workOrderTable").DataTable({
            ajax: {
                url: '/apps/helpdesk/api/workorder',
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
                {
                    data: 'subject',
                    render: function (data, type, row) {
                        var statusText = row.priority;

                        // Define status information
                        var status = {
                            'High': {"state": "warning"},
                            'Medium': {"state": "primary"},
                            'Low': {"state": "info"},
                            'Normal': {"state": "success"},
                            'Emergency': {"state": "danger"},
                        };

                        // Generate the span based on the status text
                        var statusSpan = '<span class="badge badge-light-' + status[statusText]['state'] + ' fw-semibold">' + statusText + '</span>';

                        // Concatenate the status span with the subject
                        return data + ' ' + statusSpan;
                    }
                },
                {
                    data: 'staff',
                    class: 'text-gray-900 fw-bold text-hover-primary fs-6',
                    // title: 'Reporter',
                    render: function (data, type, row) {
                        if(canSign){
                            if (type === 'display' || type === 'filter') {
                                return '<a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">'+data+'</a>'+
                                    '<a href="#" class="open-signpad" data-bs-toggle="modal" data-bs-target="#kt_modal_signaturepad" data-id="'+row.id+'" data-access="Staff"><i class="ki-duotone ki-feather fs-2"><span class="path1"></span><span class="path2"></span></i></a>';
                            }
                            return data; // For sorting and other types

                        }else{
                            if (type === 'display' || type === 'filter') {
                                return '<a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">'+data+'</a>';
                            }
                            return data; // For sorting and other types

                        }

                    }
                },
                {
                    data: 'user',
                    title: 'Reporter',
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Format the date as "YYYY-MM-DD HH:MM:SS"
                            var date = new Date(data);
                            var origin_unit = row.origin_unit;
                            if(canSign){
                                return '<a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">'+data+'</a>'+
                                '<span class="text-muted fw-semibold text-muted d-block fs-7">Unit: '+origin_unit+'</span>'+
                                '<i class="ki-duotone ki-feather fs-2"><span class="path1"></span><span class="path2"></span></i>';
                            }else{
                                return '<a href="#" class="text-gray-900 fw-bold text-hover-primary d-block mb-1 fs-6">'+data+'</a>';
                            }

                        }
                        return data; // For sorting and other types
                    }
                },
                { data: 'status' },
                { data: 'description' },
                {
                    data: 'due_date',
                    title: 'Due Date',
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Format the date as "YYYY-MM-DD HH:MM:SS"
                            return data.toLocaleString();
                        }
                        return data; // For sorting and other types
                    }
                },
                {
                    data: 'created_at',
                    title: 'Created',
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Format the date as "YYYY-MM-DD HH:MM:SS"
                            var date = new Date(data);
                            var created_by = row.created_by;
                            return created_by +'<br>'+ date.toLocaleString();
                        }
                        return data; // For sorting and other types
                    }
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
                        targets: 5,
                        visible: false
                    }
                ],
            buttons: dtButtons,
            // Use the passed data

        });



        tableWorkorder = dtWorkorder.$;
        // Refresh the DataTable to reflect the changes
        dtWorkorder.buttons().container().appendTo($('.dataTables_wrapper .col-md-6:eq(0)'));

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dtWorkorder.on('draw', function () {
            KTMenu.init(); // reinit KTMenu instances
        });
    }

    // Editor functions
    var initEditor = function() {
        var options = {selector: "#description_response", height : "480"};

            if ( KTThemeMode.getMode() === "dark" ) {
                options["skin"] = "oxide-dark";
                options["content_css"] = "dark";
            }

            tinymce.init(options);
    }


    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'workorder_subject': {
                        validators: {
                            notEmpty: {
                                message: 'Subject is required'
                            }
                        }
                    },
                    'description_response': {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
                            }
                        }
                    },
                    'start_date': {
                        validators: {
                            notEmpty: {
                                message: 'Start Time is required'
                            }
                        }
                    },
                    'finish_date': {
                        validators: {
                            notEmpty: {
                                message: 'Finish Time is required'
                            }
                        }
                    },
                    'status': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
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

        // Add a click event listener to the "Cancel" button
        cancelButton.addEventListener('click', function () {
            // Close the modal
            $('#kt_modal_work_order_response').modal('hide');
            dtWorkorder.ajax.reload();
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

                    // Get the data-id attribute value from the clicked row
                    var rowId = $(this).closest('tr').data('id');

                    var formData = {
                        // Assuming your textarea has an ID, replace 'yourTextareaId' with the actual ID
                        'workorder_response': tinymce.get('description_response').getContent(),
                        'workorder_id': $('#workorder_id').val(),
                        'workorder_subject': $('#workorder_subject').val(),
                        'tickets_id': $('#ticket_id').val(),
                        'status': $('#status').val(),
                        'start_date': $('#start_date').val(),
                        'finish_date': $('#finish_date').val(),
                        // Add other form fields if needed
                    };

                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;


                    $.ajax({
                        url: '/apps/helpdesk/api/workorder/response',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            // alert(response.message);
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            // Reset the form and Select2 tags after submission (if needed)
                            $('#kt_modal_work_order_response_form')[0].reset();

                            // Close the modal
                            $('#kt_modal_work_order_response').modal('hide');
                            

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

                                dtWorkorder.ajax.reload();

                                
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
            initEditor();
            // Elements
            form = document.querySelector('#kt_modal_work_order_response_form');
            submitButton = document.querySelector('#kt_modal_work_order_response_submit');
            cancelButton = document.querySelector('#kt_modal_work_order_response_cancel');

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
    KTWorkorder.init();
});
