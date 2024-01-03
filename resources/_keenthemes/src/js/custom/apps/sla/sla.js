"use strict";

// Class definition
var KTSla = function () {
    // Shared variables
    var tableSla, slaFormTitle;
    var dtSla;
    var dtButtons;
    var form;
    var submitButton, cancelButton, newSlaButton, xButton;
    var validator;

    // Handle form
    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'title': {
                        validators: {
                            notEmpty: {
                                message: 'Title is required'
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
                            }
                        }
                    },
                    'duration': {
                        validators: {
                            notEmpty: {
                                message: 'Duration is required'
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
            // dtSla.ajax.reload();
            $('#workOrders-table').DataTable().ajax.reload();
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

                    var formData = new FormData(document.getElementById('kt_new_sla_form'));

                    // Append issue_category to the formData
                    // formData.append('issue_category', issuecategoryOptions);

                    $.ajax({
                        url: '/apps/sla/api/sla',
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
                                $('#kt_docs_card_sla_list').collapse('show');
                                $('#kt_docs_card_sla_new').collapse('hide');
                                // dtTicket.ajax.reload();
                                $('#sla-table').DataTable().ajax.reload();
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

        newSlaButton.addEventListener('click', function (e) {
            // form = document.querySelector('#kt_new_sla_form');
            // form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            slaFormTitle.innerText = 'New SLA';

            // Find the input element by its id
            var titleInput = document.getElementById('title');
            titleInput.removeAttribute('readonly');


            // Close kt_docs_card_sla_new
            $('#kt_docs_card_sla_new').collapse('show');
            // Show kt_docs_card_sla_list
            $('#kt_docs_card_sla_list').collapse('hide');
        });

        // // Add a click event listener to the "Cancel" button
        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset();
            // Close kt_docs_card_sla_new
            $('#kt_docs_card_sla_new').collapse('hide');
            // Show kt_docs_card_sla_list
            $('#kt_docs_card_sla_list').collapse('show');
            $("#sla-table").DataTable().ajax.reload(null, false); 
        });

        $('#sla-table').on('click', '.delete-row', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // console.log('delete row click!');

            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const slaTitle = parent.querySelectorAll('td')[1].innerText;
            const slaId = $(this).data('id');
            // console.log(slaId +' '+ slaTitle);
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ slaTitle +`</b> ?`,
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
                        html: `Deleting  <b>`+ slaTitle +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            url: '/apps/sla/api/deleteSla/' + slaId,
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
                                    $('#sla-table').DataTable().ajax.reload();
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

                                console.error('Error deleting sla:', error);
                            }
                        });
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        html: `<b>`+ slaTitle +`</b> was not deleted.`,
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

        $('#sla-table').on('click', '.edit-sla', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            slaFormTitle.innerText = 'Edit SLA';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const slaTitle = parent.querySelectorAll('td')[1].innerText;
            const slaId = $(this).data('id');
            // console.log(slaId +' '+ slaTitle);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ slaTitle +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Close kt_docs_card_sla_new
                $('#kt_docs_card_sla_new').collapse('show');
                // Show kt_docs_card_sla_list
                $('#kt_docs_card_sla_list').collapse('hide');

                $.ajax({
                    url: '/apps/sla/api/sla',
                    type: 'GET',
                    data: {
                        sla_id: slaId,
                    },
                    success: function(response) {
                        $('#title').val(response.data.name);
                        $('#description').val(response.data.description);
                        $('#duration').val(response.data.duration);
                        // $('#respond_date').val(response.data.response_time);

                        // Find the input element by its id
                        var subjectInput = document.getElementById('title');
                        subjectInput.setAttribute('readonly', true);

                        // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "sla_id";
                        hiddenInput.name = "sla_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.data.id;
                        hiddenInput.readOnly = true;

                        // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_new_sla_form").appendChild(hiddenInput);
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

                        console.error('Error deleting sla:', error);
                    }
                });
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
            // handleDeleteRows();

            // Elements
            form = document.querySelector('#kt_new_sla_form');
            submitButton = document.querySelector('#kt_new_sla_submit');
            cancelButton = document.querySelector('#kt_new_sla_cancel');
            newSlaButton = document.querySelector('#kt_new_sla');
            slaFormTitle = document.getElementById('slaFormTitle');

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
    KTSla.init();
});
