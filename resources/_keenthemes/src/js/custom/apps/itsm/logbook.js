"use strict";

// Class definition
var KTLogbook = function () {
    // Shared variables
    var tableLogbook, tableStatus, logbookTitle, logbookTitleForm;
    var dtLogbook;
    var form;
    var submitButton, xButton, newLogbookButton, dtButtons;
    var validator;
    var checkSLA;

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
                            callback: {
                                message: 'Description is required',
                                callback: function (value) {
                                    // Get the plain text without HTML
                                    const text = tinyMCE.activeEditor.getContent({
                                        format: 'text',
                                    });

                                    return text.length >= 5;
                                },
                            },
                        },
                    },
                    'start_time': {
                        validators: {
                            notEmpty: {
                                message: 'Start Time is required'
                            }
                        }
                    },
                    'finish_time': {
                        validators: {
                            notEmpty: {
                                message: 'Finish Time is required'
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

            // Find the input element by its ID
            var hiddenInput = document.getElementById("logbook_id");

            // Check if the input element exists
            if (hiddenInput) {
                // Remove the input element
                hiddenInput.remove();
            }
            
            // Close kt_docs_card_logbook_new
            $('#kt_docs_card_logbook_new').collapse('hide');
            // Show kt_docs_card_logbook_list
            $('#kt_docs_card_logbook_list').collapse('show');
            $("#logbooks-table").DataTable().ajax.reload(null, false); 
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

                    let formattedStartTime, formattedEndTime;


                    // Create a DateTime object from the string
                    var startTimeString = $('#start_time').val();
                    if(startTimeString){
                        var startTime = new Date(startTimeString);
                        // Add 7 hours for GMT+7
                        startTime.setHours(startTime.getHours() + 7);
                        formattedStartTime = startTime.toISOString().slice(0, 19).replace("T", " ");
                    }

                    // Create a DateTime object from the string
                    var endTimeString = $('#finish_time').val();
                    if(endTimeString){
                        var endTime = new Date(endTimeString);
                        // Add 7 hours for GMT+7
                        endTime.setHours(endTime.getHours() + 7);
                        formattedEndTime = endTime.toISOString().slice(0, 19).replace("T", " ");
                    }

                    // var formData = new FormData(document.getElementById('kt_new_logbook_form'));
                    // var formData = {
                        // Assuming your textarea has an ID, replace 'yourTextareaId' with the actual ID
                        // 'description': tinymce.get('description').getContent(),
                        // 'logbook_id': $('#logbook_id').val(),
                        // 'start_time': $('#start_time').val(),
                        // 'end_time': $('#end_time').val(),
                        // 'start_time': formattedStartTime,
                        // 'end_time': formattedEndTime,
                        // Add other form fields if needed
                    // };

                    // console.log(formData);

                    $.ajax({
                        url: '/apps/itsm/api/logbooks',
                        type: 'POST',
                        // data: formData,
                        data: {
                            id: $('#logbook_id').val(),
                            status: $('#status').val(),
                            title: $('#title').val(),
                            description: tinymce.get('description').getContent(),
                            start_time: $('#start_time_input').val(),
                            end_time: $('#finish_time_input').val(),
                        },
                        // processData: false,  // Important: Don't process the data
                        // contentType: false,  // Important: Set content type to false
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
                                $('#kt_docs_card_logbook_list').collapse('show');
                                $('#kt_docs_card_logbook_new').collapse('hide');
                                // dtLogbook.ajax.reload();
                                $('#logbooks-table').DataTable().ajax.reload();
                                form.reset();

                                // Find the input element by its ID
                                var hiddenInput = document.getElementById("logbook_id");

                                // Check if the input element exists
                                if (hiddenInput) {
                                    // Remove the input element
                                    hiddenInput.remove();
                                }
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

        // Add a click event listener to the "New Logbook" button
        newLogbookButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_logbook_form');
            form.reset();
            e.preventDefault();

            if(isSupervisor){
                var div = document.getElementById("edit-status");
                if (div.style.display === "block") {
                    div.style.display = "none";
                }
            }

            // Change the title text when the button is clicked
            logbookTitleForm.innerText = 'New Logbook';

            // Find the input element by its id
            // var logbookInput = document.getElementById('logbook');
            // logbookInput.removeAttribute('readonly');

            const linkedPicker1Element = document.getElementById("start_time");
            const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
            const linked2 = new tempusDominus.TempusDominus(document.getElementById("finish_time"), {
                useCurrent: false,
            });

            linked1.updateOptions({
                    restrictions: {
                        // minDate: reportTime,
                    },
                });

            //using event listeners
            linkedPicker1Element.addEventListener(tempusDominus.Namespace.events.change, (e) => {
                linked2.updateOptions({
                    restrictions: {
                    minDate: e.detail.date,
                    },
                });
            });

            //using subscribe method
            const subscription = linked2.subscribe(tempusDominus.Namespace.events.change, (e) => {
                linked1.updateOptions({
                    restrictions: {
                    maxDate: e.date,
                    },
                });
                        });


            // Close kt_docs_card_logbook_new
            $('#kt_docs_card_logbook_new').collapse('show');
            // Show kt_docs_card_logbook_list
            $('#kt_docs_card_logbook_list').collapse('hide');
        });

        $('#logbooks-table').on('click', '.delete-row', function(e) {
            e.preventDefault();
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const logbookTitle = parent.querySelectorAll('td')[1].innerText;
            const logbookId = $(this).data('id');
            // console.log(logbookId +' '+ logbookTitle);
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                icon: "warning",
                html: `Are you sure you want to delete  <b>`+ logbookTitle +`</b> ?`,
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
                        html: `Deleting  <b>`+ logbookTitle +`</b>`,
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        $.ajax({
                            url: '/apps/itsm/api/logbooks/',
                            type: 'DELETE',
                            data: {
                                id: logbookId,
                                task: 'DELETE_LOGBOOK',
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
                                    $('#logbooks-table').DataTable().ajax.reload();
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

                                console.error('Error deleting logbook:', error);
                            }
                        });
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        html: `<b>`+ logbookTitle +`</b> was not deleted.`,
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

        $('#logbooks-table').on('click', '.edit-logbook', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            logbookTitleForm.innerText = 'Edit Logbook';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const logbookTitle = parent.querySelectorAll('td')[1].innerText;
            const logbookId = $(this).data('id');
            // console.log(logbookId +' '+ logbookTitle);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ logbookTitle +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Close kt_docs_card_logbook_new
                $('#kt_docs_card_logbook_new').collapse('show');
                // Show kt_docs_card_logbook_list
                $('#kt_docs_card_logbook_list').collapse('hide');

                $.ajax({
                    url: '/apps/itsm/api/logbooks',
                    type: 'GET',
                    data: {
                        id: logbookId,
                    },
                    success: function(response) {
                        $('#title').val(response.data.title);

                        if(response.data.description){
                            // Set the content of the TinyMCE editor
                            tinymce.get('description').setContent(response.data.description);
                        }
                        if(response.data.start_time){
                            $('#start_time_input').val(formatDateTime(response.data.start_time));
                        }
                        if(response.data.end_time){
                            $('#finish_time_input').val(formatDateTime(response.data.end_time));
                        }

                        // Format date and set values for report_time and respond_date
                        $('#start_time').val(formatDateTime(response.data.start_time));
                        $('#finish_time').val(formatDateTime(response.data.end_time));

                        if(isSupervisor){
                            var div = document.getElementById("edit-status");
                            if (div.style.display === "none") {
                                div.style.display = "block";
                            } 
                        }

                        selectStatus(response.data.status);


                        const linkedPicker1Element = document.getElementById("start_time");
                        const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
                        const linked2 = new tempusDominus.TempusDominus(document.getElementById("finish_time"), {
                            useCurrent: false,
                        });

                        linked1.updateOptions({
                                restrictions: {
                                },
                            });

                        //using event listeners
                        linkedPicker1Element.addEventListener(tempusDominus.Namespace.events.change, (e) => {
                            linked2.updateOptions({
                                restrictions: {
                                minDate: e.detail.date,
                                },
                            });
                        });

                        //using subscribe method
                        const subscription = linked2.subscribe(tempusDominus.Namespace.events.change, (e) => {
                            linked1.updateOptions({
                                restrictions: {
                                maxDate: e.date,
                                },
                            });
                        });
                        

                        // Find the input element by its id
                        var logbookInput = document.getElementById('title');
                        logbookInput.setAttribute('readonly', true);

                        // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "logbook_id";
                        hiddenInput.name = "logbook_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.data.id;
                        hiddenInput.readOnly = true;

                        // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_new_logbook_form").appendChild(hiddenInput);
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

                        console.error('Error deleting logbook:', error);
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

    $("#report_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
        minDate: getSevenDaysAgo(),
        minuteIncrement: 1
    });

    $("#response_time").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        maxDate: new Date(),
        minDate: getSevenDaysAgo(),
        minuteIncrement: 1
    });

    // Function to format date and time (assuming response.data.report_time and response.data.response_time are in the format 'Y-m-d H:i:s')
    function formatDateTime(dateTimeString) {
        // return moment(dateTimeString, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm');
        // Format the date using moment.js
        return moment(dateTimeString).format('YYYY-MM-DD HH:mm:ss');
    }

    function selectStatus(selectedStatus) {
        $('#status').val(selectedStatus).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
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

    // Editor functions
    var initEditor = function() {
        var options = {selector: "#description", height : "480"};

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
            form = document.querySelector('#kt_new_logbook_form');

            submitButton = document.querySelector('#kt_new_logbook_submit');

            xButton = document.querySelector('#kt_new_logbook_cancel');
            newLogbookButton = document.querySelector('#kt_new_logbook');
            logbookTitleForm = document.getElementById('logbookTitleForm');


            if(canCreateLogbook){
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
    KTLogbook.init();
});
