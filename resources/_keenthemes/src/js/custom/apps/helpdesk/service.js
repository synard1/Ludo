"use strict";

// Class definition
var KTService = function () {
    // Shared variables
    var tableService, tableStatus, serviceTitle;
    var dtService, dtStatus;
    var dtButtons;
    var form, formRequest, formNotes, formStatus, formHistory;
    var submitButton, xButton, submitButtonWO, submitButtonNotes, submitButtonStatus, closeButtonHistory, newServiceButton;
    var validator, validatorWO, validatorNotes, validatorStatus;

    // Delete service
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
                const serviceSubject = parent.querySelectorAll('td')[1].innerText;
                const serviceId = $(this).data('id');
                // console.log(serviceId);

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + serviceSubject + "?",
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
                            text: "Deleting " + serviceSubject,
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            $.ajax({
                                url: '/apps/helpdesk/api/deleteService/' + serviceId,
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
                                        dtService.draw();
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

                                    console.error('Error deleting service:', error);
                                }
                            });
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: serviceSubject + " was not deleted.",
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
                    'service': {
                        validators: {
                            notEmpty: {
                                message: 'Service is required'
                            }
                        }
                    },
                    'request_time': {
                        validators: {
                            notEmpty: {
                                message: 'Request Time is required'
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
            // Close kt_docs_card_service_new
            $('#kt_docs_card_service_new').collapse('hide');
            // Show kt_docs_card_service_list
            $('#kt_docs_card_service_list').collapse('show');
            $("#serviceRequest-table").DataTable().ajax.reload(null, false); 
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

                    var formData = new FormData(document.getElementById('kt_new_service_form'));

                    $.ajax({
                        url: '/apps/helpdesk/api/service-management/request',
                        type: 'POST',
                        data: formData,
                        processData: false,  // Important: Don't process the data
                        contentType: false,  // Important: Set content type to false
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
                                $('#kt_docs_card_service_list').collapse('show');
                                $('#kt_docs_card_service_new').collapse('hide');
                                // dtService.ajax.reload();
                                $('#serviceRequest-table').DataTable().ajax.reload();
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

        // Add a click event listener to the "New Service" button
        newServiceButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_service_form');
            form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            serviceTitle.innerText = 'New Service Request';

            // Find the input element by its id
            var serviceInput = document.getElementById('service');
            serviceInput.removeAttribute('readonly');


            // Close kt_docs_card_service_new
            $('#kt_docs_card_service_new').collapse('show');
            // Show kt_docs_card_service_list
            $('#kt_docs_card_service_list').collapse('hide');
        });

    }

    // Handle form
    var handleFormRequest = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            formRequest,
            {
                fields: {
                    'service': {
                        validators: {
                            notEmpty: {
                                message: 'Service is required'
                            }
                        }
                    },
                    'request_time': {
                        validators: {
                            notEmpty: {
                                message: 'Request Time is required'
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
            formRequest.reset();
            // Close kt_docs_card_service_new
            $('#kt_docs_card_service_new').collapse('hide');
            // Show kt_docs_card_service_list
            $('#kt_docs_card_service_list').collapse('show');
            $("#serviceRequest-table").DataTable().ajax.reload(null, false); 
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

                    var formData = new FormData(document.getElementById('kt_new_service_form'));

                    $.ajax({
                        url: '/apps/helpdesk/api/service-management/request',
                        type: 'POST',
                        data: formData,
                        processData: false,  // Important: Don't process the data
                        contentType: false,  // Important: Set content type to false
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
                                $('#kt_docs_card_service_list').collapse('show');
                                $('#kt_docs_card_service_new').collapse('hide');
                                // dtService.ajax.reload();
                                $('#serviceRequest-table').DataTable().ajax.reload();
                                formRequest.reset();
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

        // Add a click event listener to the "New Service" button
        newServiceButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_service_form');
            form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            serviceTitle.innerText = 'New Service Request';

            // Find the input element by its id
            var serviceInput = document.getElementById('service');
            serviceInput.removeAttribute('readonly');


            // Close kt_docs_card_service_new
            $('#kt_docs_card_service_new').collapse('show');
            // Show kt_docs_card_service_list
            $('#kt_docs_card_service_list').collapse('hide');
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
            handleDeleteRows();
            // Elements
            form = document.querySelector('#kt_new_service_form');
            formRequest = '';
            submitButton = document.querySelector('#kt_new_service_submit');

            xButton = document.querySelector('#kt_new_service_cancel');
            newServiceButton = document.querySelector('#kt_new_service');
            serviceTitle = document.getElementById('serviceTitle');

            if(canCreateService){
                if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                    handleForm();
                } else {
                    handleForm();
                }
            }
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTService.init();
});
