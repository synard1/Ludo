"use strict";

// Class definition
var KTCompany = function () {
    // Elements
    var form, formSla, formTeleConfig;
    var submitButton, submitButtonSla, submitButtonTele, buttonTeleTest, submitTeleConfig;
    var validator, validatorSla, validatorTele, validatorTeleConfig;
    // var passwordMeter;

    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'company': {
                        validators: {
                            notEmpty: {
                                message: 'Company Name is required'
                            }
                        }
                    },
                    'address': {
                        validators: {
                            notEmpty: {
                                message: 'Company Address is required'
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
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'Contact phone number is required'
                            }
                        }
                    },
                    'communication[]': {
                        validators: {
                            notEmpty: {
                                message: 'Please select at least one communication method'
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

                    // Your form data
                    var formData = new FormData($('#kt_company_profile_form')[0]);

                    // Get the selected communication options
                    var communicationOptions = [];
                    $("input[name='communication[]']:checked").each(function () {
                        communicationOptions.push($(this).val());
                    });

                    // Add the communication options to the formData
                    formData.append('communication', communicationOptions.join(','));


                    $.ajax({
                        url: '/setting/api/company',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        // data: {
                        //     name: $('#company').val(),
                        //     address: $('#address').val(),
                        //     phone: $('#phone').val(),
                        //     email: $('#email').val(),
                        //     website: $('#website').val(),
                        //     communication: communicationOptions
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
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;

                                // Reload the page after a successful response
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
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

    // Handle form SLA
    var handleFormSla = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorSla = FormValidation.formValidation(
            formSla,
            {
                fields: {
                    'mttr': {
                        validators: {
                            notEmpty: {
                                message: 'MTTR Duration is required'
                            }
                        }
                    },
                    'art': {
                        validators: {
                            notEmpty: {
                                message: 'ART Duration is required'
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
        submitButtonSla.addEventListener('click', function (e) {
            e.preventDefault();

            validatorSla.validate().then(function (status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitButtonSla.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButtonSla.disabled = true;

                    // Your form data
                    var formData = new FormData($('#kt_sla_form')[0]);

                    $.ajax({
                        url: '/setting/api/sla',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            // Hide loading indication
                            submitButtonSla.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonSla.disabled = false;

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
                                submitButtonSla.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonSla.disabled = false;

                                // Reload the page after a successful response
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButtonSla.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonSla.disabled = false;
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

    // Handle form SLA
    var handleFormTeleConfig = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorTeleConfig = FormValidation.formValidation(
            formTeleConfig,
            {
                fields: {
                    'bot_token': {
                        validators: {
                            notEmpty: {
                                message: 'Token is required'
                            }
                        }
                    },
                    'recipient': {
                        validators: {
                            notEmpty: {
                                message: 'Recipient ID is required'
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
        submitTeleConfig.addEventListener('click', function (e) {
            e.preventDefault();

            validatorTeleConfig.validate().then(function (status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitTeleConfig.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitTeleConfig.disabled = true;

                    // Your form data
                    var formData = new FormData($('#kt_telegram_config_form')[0]);

                    // Add the communication options to the formData
                    formData.append('task', 'SAVE');
                    formData.append('type', 'CONFIG');
                    formData.append('platform', 'telegram');

                    $.ajax({
                        url: '/setting/api/notification',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            // Hide loading indication
                            submitTeleConfig.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitTeleConfig.disabled = false;

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
                                submitTeleConfig.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitTeleConfig.disabled = false;

                                // Reload the page after a successful response
                                // location.reload();
                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitTeleConfig.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitTeleConfig.disabled = false;
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

        // Handle test Telegram
        buttonTeleTest.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Button Click');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Show loading indication
            buttonTeleTest.setAttribute('data-kt-indicator', 'on');

            // Disable button to avoid multiple click
            buttonTeleTest.disabled = true;

            // Your form data
            var formData = new FormData($('#kt_telegram_config_form')[0]);

            // Add the communication options to the formData
            formData.append('task', 'TEST');
            formData.append('type', 'CONFIG');
            formData.append('platform', 'telegram');

            $.ajax({
                url: '/setting/api/notification',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Hide loading indication
                    buttonTeleTest.removeAttribute('data-kt-indicator');

                    // Enable button
                    buttonTeleTest.disabled = false;

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
                        buttonTeleTest.removeAttribute('data-kt-indicator');

                        // Enable button
                        buttonTeleTest.disabled = false;

                        // Reload the page after a successful response
                        // location.reload();
                    });
                },
                error: function (xhr) {
                    // Handle errors here
                    // Hide loading indication
                    buttonTeleTest.removeAttribute('data-kt-indicator');

                    // Enable button
                    buttonTeleTest.disabled = false;
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
                    'company': {
                        validators: {
                            notEmpty: {
                                message: 'Company Name is required'
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
            // Elements
            formSla = document.querySelector('#kt_sla_form');
            submitButtonSla = document.querySelector('#kt_sla_dashboard_submit');

            formTeleConfig = document.querySelector('#kt_telegram_config_form');
            submitButtonTele = document.querySelector('#kt_notification_telegram_submit'); 
            submitTeleConfig = document.querySelector('#kt_config_telegram_submit'); 
            buttonTeleTest = document.querySelector('#kt_notification_telegram_test'); 

            form = document.querySelector('#kt_company_profile_form');
            submitButton = document.querySelector('#kt_company_profile_submit');

            if (isValidUrl(submitButtonSla.closest('form').getAttribute('action'))) {
                handleFormSla();
            }else{
                handleFormSla();
            }

            if (isValidUrl(submitTeleConfig.closest('form').getAttribute('action'))) {
                handleFormTeleConfig();
            }else{
                handleFormTeleConfig();
            }

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
    KTCompany.init();
});
