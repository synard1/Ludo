"use strict";

// Class definition
var KTIncident = function () {
    // Shared variables
    var tableIncident, tableStatus, incidentTitle, incidentTitleForm;
    var dtIncident, dtStatus;
    var dtButtons;
    var form, formWO, formCategory;
    var submitButton, xButton, newIncidentButton, submitButtonWO, submitCategory, cancelCategory, newCategory;
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
                            type: 'incident',
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

                                $('#incidents-table').DataTable().ajax.reload();

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

        $('#incidents-table').on('click', '.generate-work-order', function() {
            var id = $(this).data('id');
            var title = $(this).data('title');

            fetchStaffData();

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#data_id').val(id);
            $('#titleWorkOrder').val(title);
            console.log('Generate work order for ID: ' + id);
            console.log('Generate work order for title: ' + title);
        });

        // var options = {
        //     selector: "#description_wo",
        //     height: "480"
        // };

        // if (KTThemeMode.getMode() === "dark") {
        //     options["skin"] = "oxide-dark";
        //     options["content_css"] = "dark";
        // }

        // tinymce.init(options);

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
                        url: '/apps/itsm/api/incidentCategories',
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

                                $('#incidentCategory-tables').DataTable().ajax.reload();

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

        // Add a click event listener to the "New Incident" button
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

        $('#incidentCategory-tables').on('click', '.delete-category', function(e) {
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
                            // url: '/apps/itsm/api/deleteIncident/' + categoryId,
                            url: '/apps/itsm/api/incidentCategories',
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
                                    $('#incidentCategory-tables').DataTable().ajax.reload();
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

                                console.error('Error deleting incident:', error);
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
                    'incident': {
                        validators: {
                            notEmpty: {
                                message: 'Incident title is required'
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
            // Close kt_docs_card_incident_new
            $('#kt_docs_card_incident_new').collapse('hide');
            // Show kt_docs_card_incident_list
            $('#kt_docs_card_incident_list').collapse('show');
            $("#incidents-table").DataTable().ajax.reload(null, false); 
        });

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // --- Tambahan validasi jam kerja ---
            const reportTime = $('#report_time').val();
            const responseTime = $('#response_time').val();
            let outOfHours = false;
            let msg = '';
            let workingHours = window.workingHours || {start: '05:00', end: '18:00'};
            
            if (isOutsideWorkingHours(reportTime)) {
                outOfHours = true;
                let reportTimeObj = moment(reportTime, ["YYYY-MM-DD HH:mm", "YYYY-MM-DD HH:mm:ss"], true);
                let timeStr = reportTimeObj.format('HH:mm');
                msg += `- Report Time (${timeStr}) di luar jam kerja (${workingHours.start} - ${workingHours.end})\n`;
            }
            if (isOutsideWorkingHours(responseTime)) {
                outOfHours = true;
                let responseTimeObj = moment(responseTime, ["YYYY-MM-DD HH:mm", "YYYY-MM-DD HH:mm:ss"], true);
                let timeStr = responseTimeObj.format('HH:mm');
                msg += `- Response Time (${timeStr}) di luar jam kerja (${workingHours.start} - ${workingHours.end})\n`;
            }
            if (outOfHours) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Waktu input di luar jam kerja. Apakah Anda yakin ingin melanjutkan simpan?\n\n' + msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                doSubmitAjax();
                            }
                        });
                    }
                });
                return;
            }
            // --- End tambahan validasi jam kerja ---

            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    doSubmitAjax();
                } else {
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

        // Ekstrak submit ajax ke fungsi agar bisa dipanggil ulang
        function doSubmitAjax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Show loading indication
            submitButton.setAttribute('data-kt-indicator', 'on');
            // Disable button to avoid multiple click
            submitButton.disabled = true;
            var formData = new FormData(document.getElementById('kt_new_incident_form'));
            // Get the selected issuecategory options
            var issuecategoryOptions = [];
            $("input[name='category[]']:checked").each(function () {
                issuecategoryOptions.push($(this).val());
            });
            $.ajax({
                url: '/apps/itsm/api/incidents',
                type: 'POST',
                data: formData,
                processData: false,  // Important: Don't process the data
                contentType: false,  // Important: Set content type to false
                success: function (response) {
                    submitButton.removeAttribute('data-kt-indicator');
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
                        $('#kt_docs_card_incident_list').collapse('show');
                        $('#kt_docs_card_incident_new').collapse('hide');
                        $('#incidents-table').DataTable().ajax.reload();
                        form.reset();
                    });
                },
                error: function (xhr) {
                    submitButton.removeAttribute('data-kt-indicator');
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
        }

        // Add a click event listener to the "New Incident" button
        newIncidentButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_incident_form');
            form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            incidentTitleForm.innerText = 'New Incident';

            // Find the input element by its id
            var incidentInput = document.getElementById('incident');
            incidentInput.removeAttribute('readonly');


            // Close kt_docs_card_incident_new
            $('#kt_docs_card_incident_new').collapse('show');
            // Show kt_docs_card_incident_list
            $('#kt_docs_card_incident_list').collapse('hide');
        });

        $('#incidents-table').on('click', '.delete-row', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // console.log('delete row click!');

            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const incidentTitle = parent.querySelectorAll('td')[2].innerText;
            const incidentId = $(this).data('id');
            // console.log(incidentId +' '+ incidentTitle);
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ incidentTitle +`</b> ?`,
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
                        html: `Deleting  <b>`+ incidentTitle +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            url: '/apps/itsm/api/deleteIncident/' + incidentId,
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
                                    $('#incidents-table').DataTable().ajax.reload();
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

                                console.error('Error deleting incident:', error);
                            }
                        });
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        html: `<b>`+ incidentTitle +`</b> was not deleted.`,
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

        $('#incidents-table').on('click', '.edit-incident', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            incidentTitleForm.innerText = 'Edit Incident';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const incidentTitle = parent.querySelectorAll('td')[2].innerText;
            const incidentId = $(this).data('id');
            // console.log(incidentId +' '+ incidentTitle);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ incidentTitle +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Close kt_docs_card_incident_new
                $('#kt_docs_card_incident_new').collapse('show');
                // Show kt_docs_card_incident_list
                $('#kt_docs_card_incident_list').collapse('hide');

                $.ajax({
                    url: '/apps/itsm/api/incidents',
                    type: 'GET',
                    data: {
                        id: incidentId,
                    },
                    success: function(response) {
                        $('#incident').val(response.data.title);
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
                        var incidentInput = document.getElementById('incident');
                        incidentInput.setAttribute('readonly', false); // User Requested

                        // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "incident_id";
                        hiddenInput.name = "incident_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.data.id;
                        hiddenInput.readOnly = true;

                        // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_new_incident_form").appendChild(hiddenInput);
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

                        console.error('Error deleting incident:', error);
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

    // Helper: Cek jam kerja
    function isOutsideWorkingHours(timeStr) {
        if (!timeStr) return false;
        // Support format dari flatpickr: 'YYYY-MM-DD HH:mm' atau 'YYYY-MM-DD HH:mm:ss'
        let input = moment(timeStr, ["YYYY-MM-DD HH:mm", "YYYY-MM-DD HH:mm:ss"], true);
        if (!input.isValid()) return false;
        const hours = input.hours();
        const minutes = input.minutes();
        const inputHM = hours * 60 + minutes;
        let workingHours = window.workingHours || {start: '05:00', end: '18:00'};
        const [startH, startM] = workingHours.start.split(':').map(Number);
        const [endH, endM] = workingHours.end.split(':').map(Number);
        const startHM = startH * 60 + startM;
        const endHM = endH * 60 + endM;
        if (startHM < endHM) {
            return inputHM < startHM || inputHM > endHM;
        } else {
            return inputHM < startHM && inputHM > endHM;
        }
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            initEditor();
            // Elements
            form = document.querySelector('#kt_new_incident_form');
            formCategory = document.querySelector('#kt_modal_new_category_form');

            submitButton = document.querySelector('#kt_new_incident_submit');
            submitCategory = document.querySelector('#kt_modal_new_category_submit');

            formWO = document.querySelector('#kt_modal_new_work_order_form');
            submitButtonWO = document.querySelector('#kt_modal_new_work_order_submit');

            xButton = document.querySelector('#kt_new_incident_cancel');
            cancelCategory = document.querySelector('#kt_modal_new_category_cancel');

            newIncidentButton = document.querySelector('#kt_new_incident');
            newCategory = document.querySelector('#kt_new_incident_category');
            incidentTitleForm = document.getElementById('incidentTitleForm');

            if(slaExist){
                checkSLA = true;
            }else{
                checkSLA = false;
            }

            if(canCreateIncidentCategory){
                if (isValidUrl(submitCategory.closest('form').getAttribute('action'))) {
                    handleFormCategory();
                } else {
                    handleFormCategory();
                }
            }

            if(canCreateIncident){
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
    KTIncident.init();
});
