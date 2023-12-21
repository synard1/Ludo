"use strict";

// Class definition
var KTVersion = function () {
    // Elements
    var form;
    var submitButton, newVersionButton, xButton;
    var validator;

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
                    'release_date': {
                        validators: {
                            notEmpty: {
                                message: 'Release Date is required'
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
                    'type': {
                        validators: {
                            notEmpty: {
                                message: 'Release type is required'
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

        // Add a click event listener to the "New Ticket" button
        newVersionButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_version_form');
            form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            versionTitle.innerText = 'New Version';

            // Find the input element by its id
            var subjectInput = document.getElementById('subject');
            subjectInput.removeAttribute('readonly');


            // Close kt_docs_card_version_new
            $('#kt_docs_card_version_new').collapse('show');
            // Show kt_docs_card_version_list
            $('#kt_docs_card_version_list').collapse('hide');
        });

        // Add a click event listener to the "Cancel" button
        xButton.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset();
            // Close kt_docs_card_version_new
            $('#kt_docs_card_version_new').collapse('hide');
            // Show kt_docs_card_version_list
            $('#kt_docs_card_version_list').collapse('show');
            $("#versions-table").DataTable().ajax.reload(null, false); 
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

                    // Your form data
                    var formData = new FormData($('#kt_new_version_form')[0]);

                    $.ajax({
                        url: '{{ route("semver.api.postVersion") }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
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

    

    

    var isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }

    $("#release_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: new Date(),
    });

    // Get the date exactly 7 days ago
    function getSevenDaysAgo() {
        var today = new Date();
        var sevenDaysAgo = new Date(today);
        sevenDaysAgo.setDate(today.getDate() - 7);
        return sevenDaysAgo;
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            // Elements
            newVersionButton = document.querySelector('#kt_new_version');
            xButton = document.querySelector('#kt_new_version_cancel');
            form = document.querySelector('#kt_new_version_form');
            submitButton = document.querySelector('#kt_new_version_submit');
            // passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                handleForm();
            } else {
                handleForm();
            }
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTVersion.init();
});
