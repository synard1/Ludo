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
                $("#workorders-table").DataTable().ajax.reload(null, false); 
            }
        };

        
        dtWorkorder = $("#workorders-table").DataTable({
            scrollX: true,
            ajax: {
                url: '/apps/itsm/api/workorder',
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
                            callback: {
                                message: 'Response is required',
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
                    // 'description_response': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Description is required'
                    //         }
                    //     }
                    // },
                    'start_time': {
                        validators: {
                            notEmpty: {
                                message: 'Start Time is required',
                            }
                        }
                    },
                    // 'finish_time_input': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Finish Time is required'
                    //         }
                    //     }
                    // },
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
            // dtWorkorder.ajax.reload();
            $('#workorders-table').DataTable().ajax.reload();
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
                    let formattedStartTime, formattedEndTime;


                    // Create a DateTime object from the string
                    var startTimeString = $('#start_time_input').val();
                    if(startTimeString){
                        var startTime = new Date(startTimeString);
                        // Add 7 hours for GMT+7
                        startTime.setHours(startTime.getHours() + 7);
                        formattedStartTime = startTime.toISOString().slice(0, 19).replace("T", " ");
                    }

                    // Create a DateTime object from the string
                    var endTimeString = $('#finish_time_input').val();
                    if(endTimeString){
                        var endTime = new Date(endTimeString);
                        // Add 7 hours for GMT+7
                        endTime.setHours(endTime.getHours() + 7);
                        formattedEndTime = endTime.toISOString().slice(0, 19).replace("T", " ");
                    }

                    var formData = {
                        // Assuming your textarea has an ID, replace 'yourTextareaId' with the actual ID
                        'description': tinymce.get('description_response').getContent(),
                        'workorder_id': $('#workorder_id').val(),
                        'workorder_subject': $('#workorder_subject').val(),
                        'module': $('#module').val(),
                        'status': $('#status').val(),
                        'start_time': formattedStartTime,
                        'end_time': formattedEndTime,
                        // Add other form fields if needed
                    };

                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;


                    $.ajax({
                        url: '/apps/itsm/api/workorder/response',
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

                                // dtWorkorder.ajax.reload();
                                $('#workorders-table').DataTable().ajax.reload();

                                
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

        $('#workorders-table').on('click', '.generate-work-order-response', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            // Change the title text when the button is clicked
            // incidentTitleForm.innerText = 'Edit Incident';
            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const workorderNumber = parent.querySelectorAll('td')[1].innerText;
            const workorderId = $(this).data('id');
            // console.log(workorderId +' '+ workorderNumber);

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ workorderNumber +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Open the modal
                $('#kt_modal_work_order_response').modal('show');

                $.ajax({
                    // url: '/apps/itsm/api/workorder',
                    // url: '/apps/itsm/api/workorder/' + workorderId,
                    url: '/apps/itsm/api/workorder',
                    type: 'GET',
                    data: {
                        id: workorderId,
                        task: 'WORK_ORDER_RESPONSE',
                    },
                    success: function(response) {
                        console.log(response);
                        $('#workorder_subject').val(response.subject);
                        if(response.description){
                            // Set the content of the TinyMCE editor
                            tinymce.get('description_response').setContent(response.description);
                        }
                        if(response.start_time){
                            $('#start_time_input').val(formatDateTime(response.start_time));
                        }
                        if(response.end_time){
                            $('#finish_time_input').val(formatDateTime(response.end_time));
                        }
                        
                        // $('#description').val(response.description);

                        // Format date and set values for report_time and respond_date
                        $('#report_time').val(formatDateTime(response.report_time));
                        $('#response_time').val(formatDateTime(response.response_time));
                        
                        selectStatusResponse(response.status);

                        let reportTime = new Date(response.response_time);
                        // let reportTime = new Date($(this).data('report-time'));
                        // let reportTime = formatDateTime(response.response_time);
                        // console.log(reportTime);

                        const linkedPicker1Element = document.getElementById("start_time");
                        const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
                        const linked2 = new tempusDominus.TempusDominus(document.getElementById("finish_time"), {
                            useCurrent: false,
                        });

                        linked1.updateOptions({
                                restrictions: {
                                    minDate: reportTime,
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
                        // var incidentInput = document.getElementById('incident');
                        // incidentInput.setAttribute('readonly', true);

                        // // Create a new hidden input element
                        // var hiddenInput = document.createElement("input");
                        // hiddenInput.type = "hidden";
                        // hiddenInput.id = "module";
                        // hiddenInput.name = "module";
                        // hiddenInput.className = "form-control form-control-solid";
                        // hiddenInput.value = response.module;
                        // hiddenInput.readOnly = true;

                        // // Find the form by its id and append the hidden input to it
                        // document.getElementById("kt_modal_work_order_response_form").appendChild(hiddenInput);

                        // Create a new hidden input element for 'module'
                        var hiddenModuleInput = document.createElement("input");
                        hiddenModuleInput.type = "hidden";
                        hiddenModuleInput.id = "module";
                        hiddenModuleInput.name = "module";
                        hiddenModuleInput.className = "form-control form-control-solid";
                        hiddenModuleInput.value = response.module;
                        hiddenModuleInput.readOnly = true;

                        // Create a new hidden input element for 'workorder_id'
                        var hiddenWorkorderIdInput = document.createElement("input");
                        hiddenWorkorderIdInput.type = "hidden";
                        hiddenWorkorderIdInput.id = "workorder_id";
                        hiddenWorkorderIdInput.name = "workorder_id";
                        hiddenWorkorderIdInput.className = "form-control form-control-solid";
                        hiddenWorkorderIdInput.value = response.id;
                        hiddenWorkorderIdInput.readOnly = true;

                        // Find the form by its id and append the hidden inputs to it
                        var form = document.getElementById("kt_modal_work_order_response_form");
                        form.appendChild(hiddenModuleInput);
                        form.appendChild(hiddenWorkorderIdInput);
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


    // Handle form ajax
    // var handleFormAjax = function (e) {
    //     // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    //     validator = FormValidation.formValidation(
    //         form,
    //         {
    //             fields: {
    //                 'subject': {
    //                     validators: {
    //                         notEmpty: {
    //                             message: 'Subject is required'
    //                         }
    //                     }
    //                 },
    //                 'email': {
    //                     validators: {
    //                         regexp: {
    //                             regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    //                             message: 'The value is not a valid email address',
    //                         },
    //                         notEmpty: {
    //                             message: 'Email address is required'
    //                         }
    //                     }
    //                 },
    //                 'toc': {
    //                     validators: {
    //                         notEmpty: {
    //                             message: 'You must accept the terms and conditions'
    //                         }
    //                     }
    //                 }
    //             },
    //             plugins: {
    //                 trigger: new FormValidation.plugins.Trigger({
    //                     event: {
    //                         password: false
    //                     }
    //                 }),
    //                 bootstrap: new FormValidation.plugins.Bootstrap5({
    //                     rowSelector: '.fv-row',
    //                     eleInvalidClass: '',  // comment to enable invalid state icons
    //                     eleValidClass: '' // comment to enable valid state icons
    //                 })
    //             }
    //         }
    //     );

    //     // Handle form submit
    //     submitButton.addEventListener('click', function (e) {
    //         e.preventDefault();

    //         // validator.revalidateField('password');

    //         validator.validate().then(function (status) {
    //             if (status == 'Valid') {
    //                 // Show loading indication
    //                 submitButton.setAttribute('data-kt-indicator', 'on');

    //                 // Disable button to avoid multiple click
    //                 submitButton.disabled = true;


    //                 // Check axios library docs: https://axios-http.com/docs/intro
    //                 axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
    //                     if (response) {
    //                         form.reset();

    //                         const redirectUrl = form.getAttribute('data-kt-redirect-url');

    //                         if (redirectUrl) {
    //                             location.href = redirectUrl;
    //                         }
    //                     } else {
    //                         // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
    //                         Swal.fire({
    //                             text: "Sorry, looks like there are some errors detected, please try again.",
    //                             icon: "error",
    //                             buttonsStyling: false,
    //                             confirmButtonText: "Ok, got it!",
    //                             customClass: {
    //                                 confirmButton: "btn btn-primary"
    //                             }
    //                         });
    //                     }
    //                 }).catch(function (error) {
    //                     Swal.fire({
    //                         text: "Sorry, looks like there are some errors detected, please try again.",
    //                         icon: "error",
    //                         buttonsStyling: false,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn btn-primary"
    //                         }
    //                     });
    //                 }).then(() => {
    //                     // Hide loading indication
    //                     submitButton.removeAttribute('data-kt-indicator');

    //                     // Enable button
    //                     submitButton.disabled = false;
    //                 });

    //             } else {
    //                 // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
    //                 Swal.fire({
    //                     text: "Sorry, looks like there are some errors detected, please try again.",
    //                     icon: "error",
    //                     buttonsStyling: false,
    //                     confirmButtonText: "Ok, got it!",
    //                     customClass: {
    //                         confirmButton: "btn btn-primary"
    //                     }
    //                 });
    //             }
    //         });
    //     });

    // }

    var isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }

    // Function to format date and time (assuming response.data.report_time and response.data.response_time are in the format 'Y-m-d H:i:s')
    function formatDateTime(dateTimeString) {
        // return moment(dateTimeString, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm');
        // Format the date using moment.js
        return moment(dateTimeString).format('YYYY-MM-DD HH:mm:ss');
    }

    function selectStatusResponse(selectedStatus) {
        $('#status').val(selectedStatus).trigger('change'); // Assuming you are using a library like Select2 for the dropdown
    }

    // $("#start_time").flatpickr({
    //     enableTime: true,
    //     dateFormat: "Y-m-d H:i",
    //     minuteIncrement: 1
    // });

    // Public functions
    return {
        // Initialization
        init: function () {
            // initDatatable();
            initEditor();
            // Elements
            form = document.querySelector('#kt_modal_work_order_response_form');
            submitButton = document.querySelector('#kt_modal_work_order_response_submit');
            cancelButton = document.querySelector('#kt_modal_work_order_response_cancel');

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
    KTWorkorder.init();
});
