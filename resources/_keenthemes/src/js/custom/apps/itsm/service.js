"use strict";

// Class definition
var KTService = function () {
    // Shared variables
    var tableService, tableStatus, serviceTitle, serviceTitleForm;
    var dtService, dtStatus;
    var dtButtons;
    var form, formWO, formCategory;
    var submitButton, xButton, newServiceButton, submitButtonWO, submitCategory, cancelCategory, newCategory;
    var validator, validatorWO, validatorCategory;
    var checkSLA;

    // Handle form Work Order
    var handleFormWO = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorWO = FormValidation.formValidation(
            formWO,
            {
                fields: {
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
                    // 'description_wo': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Description is required'
                    //         }
                    //     }
                    // },
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

                    // var formData1 = new FormData(document.getElementById('kt_modal_new_work_order_form'));
                    console.log($('#description_wo').val());

                    $.ajax({
                        url: '/apps/itsm/api/workorder',
                        type: 'POST',
                        // data: formData1,
                        data: {
                            data_id: $('#data_id').val(),
                            // description: $('#description_wo').val(),
                            description: tinymce.get('description_wo').getContent(),
                            due_date: $('#due_date').val(),
                            sla: $('#sla').val(),
                            staff: $('#staffSelect').val(),
                            priority: $('#priority').val(),
                            type: 'service',
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

                                $('#services-table').DataTable().ajax.reload();

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

        $('#services-table').on('click', '.generate-work-order', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');

            fetchStaffData();

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#data_id').val(id);
            $('#titleWorkOrder').val(title);
            console.log('Generate work order for ID: ' + id);
            console.log('Generate work order for title: ' + title);
        });

    }

    // Handle form Category
    var handleFormCategory = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorCategory = FormValidation.formValidation(
            formCategory,
            {
                fields: {
                    'title': {
                        validators: {
                            notEmpty: {
                                message: 'Title is required',
                            }
                        }
                    },
                    'description_category': {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
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
        submitCategory.addEventListener('click', function (e) {
            e.preventDefault();

            validatorCategory.validate().then(function (status) {
                if (status == 'Valid') {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Show loading indication
                    submitCategory.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitCategory.disabled = true;

                    // var formData1 = new FormData(document.getElementById('kt_modal_new_work_order_form'));
                    // console.log($('#description_wo').val());

                    $.ajax({
                        url: '/apps/itsm/api/serviceCategories',
                        type: 'POST',
                        // data: formData1,
                        data: {
                            id: $('#category_id').val(),
                            name: $('#title').val(),
                            description: $('#description_category').val(),
                            task: 'SAVE_CATEGORY',
                            // description: tinymce.get('description_wo').getContent(),
                        },
                        success: function (response) {
                            // alert(response.message);
                            // Hide loading indication
                            submitCategory.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitCategory.disabled = false;

                            // Reset the form and Select2 tags after submission (if needed)
                            $('#kt_modal_new_category_form')[0].reset();
                            // staffSelect.val(null).trigger('change');

                            // Close the modal
                            $('#kt_modal_category').modal('hide');

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
                                submitCategory.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitCategory.disabled = false;

                                $('#serviceCategory-tables').DataTable().ajax.reload();

                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitCategory.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitCategory.disabled = false;

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
        newCategory.addEventListener('click', function (e) {
            // formCategory = document.querySelector('#kt_modal_new_category_form');
            formCategory.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            // categoryTitleForm.innerText = 'New Category';

            // // Find the input element by its id
            var categoryInput = document.getElementById('title');
            categoryInput.removeAttribute('readonly');

            // Open the modal
            $('#kt_modal_category').modal('show');
        });

        $('#serviceCategory-tables').on('click', '.delete-category', function(e) {
            e.preventDefault();

            //Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const categoryTitle = parent.querySelectorAll('td')[1].innerText;
            const categoryId = $(this).data('id');

            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ categoryTitle +`</b> ?`,
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
                        html: `Deleting  <b>`+ categoryTitle +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            // url: '/apps/itsm/api/deleteService/' + categoryId,
                            url: '/apps/itsm/api/serviceCategories',
                            type: 'DELETE',
                            data: {
                                id: categoryId,
                                task: 'DELETE_CATEGORY',
                                // description: tinymce.get('description_wo').getContent(),
                            },
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
                                    $('#serviceCategory-tables').DataTable().ajax.reload();
                                    formCategory.reset();
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
                        html: `<b>`+ categoryTitle +`</b> was not deleted.`,
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
                    'classification': {
                        validators: {
                            notEmpty: {
                                message: 'Classification is required'
                            }
                        }
                    },
                    'service': {
                        validators: {
                            notEmpty: {
                                message: 'Service title is required'
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
                    'location': {
                        validators: {
                            notEmpty: {
                                message: 'Location is required'
                            }
                        }
                    },
                    'source': {
                        validators: {
                            notEmpty: {
                                message: 'Report Sources is required'
                            }
                        }
                    },
                    // 'reportedBy': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Reported User is required'
                    //         }
                    //     }
                    // },
                    'category[]': {
                        validators: {
                            choice: {
                                min: 1,
                                max: 5,
                                message: 'Please check minimum 1 category'
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
                    'response_time': {
                        validators: {
                            notEmpty: {
                                message: 'Response Time is required'
                            }
                        }
                    },
                    'severity': {
                        validators: {
                            notEmpty: {
                                message: 'Severity is required'
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
            $("#services-table").DataTable().ajax.reload(null, false); 
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

                    // Check if formData has the 'ticket_id' input
                    if (formData.has('service_id')) {
                        // Get the selected issuecategory options
                        var issuecategoryOptions = [];
                        $("input[name='category[]']:checked").each(function () {
                            issuecategoryOptions.push($(this).val());
                        });
                        
                    } else {

                        // Get the selected issuecategory options
                        var issuecategoryOptions = [];
                        $("input[name='category[]']:checked").each(function () {
                            issuecategoryOptions.push($(this).val());
                        });
                    }

                    $.ajax({
                        url: '/apps/itsm/api/services',
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
                                $('#services-table').DataTable().ajax.reload();
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
            serviceTitleForm.innerText = 'New Service';

            // Find the input element by its id
            var serviceInput = document.getElementById('service');
            serviceInput.removeAttribute('readonly');


            // Close kt_docs_card_service_new
            $('#kt_docs_card_service_new').collapse('show');
            // Show kt_docs_card_service_list
            $('#kt_docs_card_service_list').collapse('hide');
        });

        $('#services-table').on('click', '.delete-row', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // console.log('delete row click!');

            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const serviceTitle = parent.querySelectorAll('td')[2].innerText;
            const serviceId = $(this).data('id');
            // console.log(serviceId +' '+ serviceTitle);
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ serviceTitle +`</b> ?`,
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
                        html: `Deleting  <b>`+ serviceTitle +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            url: '/apps/itsm/api/deleteService/' + serviceId,
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
                                    $('#services-table').DataTable().ajax.reload();
                                    form.reset();
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
                        html: `<b>`+ serviceTitle +`</b> was not deleted.`,
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

        $('#services-table').on('click', '.edit-service', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            serviceTitleForm.innerText = 'Edit Service';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const serviceTitle = parent.querySelectorAll('td')[2].innerText;
            const serviceId = $(this).data('id');
            // console.log(serviceId +' '+ serviceTitle);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ serviceTitle +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Close kt_docs_card_service_new
                $('#kt_docs_card_service_new').collapse('show');
                // Show kt_docs_card_service_list
                $('#kt_docs_card_service_list').collapse('hide');

                $.ajax({
                    url: '/apps/itsm/api/services',
                    type: 'GET',
                    data: {
                        id: serviceId,
                    },
                    success: function(response) {
                        $('#service').val(response.data.title);
                        $('#description').val(response.data.description);

                        // Format date and set values for report_time and respond_date
                        $('#report_time').val(formatDateTime(response.data.report_time));
                        $('#response_time').val(formatDateTime(response.data.response_time));

                        // Auto-select the unit-dropdown based on response.data.origin_unit
                        selectClassification(response.data.category_id);
                        selectLocation(response.data.location);
                        selectSource(response.data.source);
                        selectReporter(response.data.reportedBy);
                        selectSeverity(response.data.severity);

                        response.data.category.forEach(function(category) {
                            $('input[name="category[]"][value="' + category + '"]').prop('checked', true);
                        });

                        // Find the input element by its id
                        var serviceInput = document.getElementById('service');
                        serviceInput.setAttribute('readonly', true);

                        // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "service_id";
                        hiddenInput.name = "service_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.data.id;
                        hiddenInput.readOnly = true;

                        // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_new_service_form").appendChild(hiddenInput);
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
        minDate: getThirtyDaysAgo(),
        minuteIncrement: 1
    });

    $("#response_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
        minDate: getThirtyDaysAgo(),
        minuteIncrement: 1
    });

    $("#due_date").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 1
    });

    // Function to format date and time (assuming response.data.report_time and response.data.response_time are in the format 'Y-m-d H:i:s')
    function formatDateTime(dateTimeString) {
        // return moment(dateTimeString, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm');
        // Format the date using moment.js
        return moment(dateTimeString).format('YYYY-MM-DD HH:mm:ss');
    }

    // Function to auto-select unit in dropdown
    function selectClassification(selectedClassification) {
        $('#classification').val(selectedClassification).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    function selectSeverity(selectedSeverity) {
        $('#severity').val(selectedSeverity).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    function selectLocation(selectedLocation) {
        $('#location').val(selectedLocation).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    function selectReporter(selectedUser) {
        $('#reportedBy').val(selectedUser).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    function selectSource(selectedSource) {
        $('#source').val(selectedSource).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
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

    // Get the date exactly 30 days ago
    function getThirtyDaysAgo() {
        var today = new Date();
        var thirtyDaysAgo = new Date(today);
        thirtyDaysAgo.setDate(today.getDate() - 30);
        return thirtyDaysAgo;
    }

    // Editor functions
    var initEditor = function() {
        var options = {selector: "#description_wo", height : "480"};

            if ( KTThemeMode.getMode() === "dark" ) {
                options["skin"] = "oxide-dark";
                options["content_css"] = "dark";
            }

            tinymce.init(options);
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            initEditor();
            // Elements
            form = document.querySelector('#kt_new_service_form');
            formCategory = document.querySelector('#kt_modal_new_category_form');

            submitButton = document.querySelector('#kt_new_service_submit');
            submitCategory = document.querySelector('#kt_modal_new_category_submit');

            formWO = document.querySelector('#kt_modal_new_work_order_form');
            submitButtonWO = document.querySelector('#kt_modal_new_work_order_submit');

            xButton = document.querySelector('#kt_new_service_cancel');
            cancelCategory = document.querySelector('#kt_modal_new_category_cancel');

            newServiceButton = document.querySelector('#kt_new_service');
            newCategory = document.querySelector('#kt_new_service_category');
            serviceTitleForm = document.getElementById('serviceTitleForm');

            if(slaExist){
                checkSLA = true;
            }else{
                checkSLA = false;
            }

            if(canCreateServiceCategory){
                if (isValidUrl(submitCategory.closest('form').getAttribute('action'))) {
                    handleFormCategory();
                } else {
                    handleFormCategory();
                }
            }

            if(canCreateService){
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
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTService.init();
});
