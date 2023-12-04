@php

    $canCreateTicket = auth()->check() && auth()->user()->level_access === 'Supervisor';
    $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

@endphp

<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Ticket List</h3>
            <div class="card-toolbar rotate-180">
                <i class="ki-duotone ki-down fs-1"></i>

            </div>
        </div>
        <div id="kt_docs_card_ticket_list" class="collapse show">
            <div class="card-body">
                <table id="ticketTable"
                    class="display responsive nowrap table table-striped table-row-bordered gy-5 gs-7"
                    style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>Subject</th>
                            <th>Operator</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Sources</th>
                            <th>Priority</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Work Order</th>
                            <th>Action</th>
                            {{-- <th>Created At</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @if($canCreateTicket)
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">New Ticket</h3>
            <div class="card-toolbar rotate-180">
                <i class="ki-duotone ki-down fs-1"></i>
            </div>
        </div>
        <div id="kt_docs_card_ticket_new" class="collapse">
            <!--begin::Form-->
            <form id="kt_new_ticket_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate">
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Input group-->
                    <div class="row mb-2">
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Subject</span>
                            </label>
                            <!--end::Label-->

                            <input type="text" class="form-control form-control-solid"
                                placeholder="Enter your ticket subject" name="subject" id="subject">
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-2">
                        <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                Description
                            </label>
                            <!--end::Label-->

                            <textarea class="form-control form-control-solid" name="description"
                                id="description"> </textarea>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="form-label"><span class="required">Unit:</span></label>
                            <div class="input-group">
                                <livewire:helpdesk::unit-select />
                            </div>
                        </div>
                        <div class="col">
                            <label for="" class="form-label">User:</label>
                            <div class="input-group">
                                <livewire:helpdesk::reporter-select />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
<div class="row mb-4">
    <div class="col-12">
        <!-- Category -->
        <div class="mb-3">
            <label class="form-label required fw-semibold fs-6">Category</label>
            <div class="d-flex flex-column">
                <!-- Options -->
                <div class="form-check form-check-custom mb-2">
                    <input class="form-check-input" name="issuecategory[]" type="checkbox" value="Hardware">
                    <label class="form-check-label fw-semibold ps-2 fs-6">Hardware</label>
                </div>
                <div class="form-check form-check-custom mb-2">
                    <input class="form-check-input" name="issuecategory[]" type="checkbox" value="Software">
                    <label class="form-check-label fw-semibold ps-2 fs-6">Software</label>
                </div>
                <div class="form-check form-check-custom mb-2">
                    <input class="form-check-input" name="issuecategory[]" type="checkbox" value="Disaster">
                    <label class="form-check-label fw-semibold ps-2 fs-6">Disaster</label>
                </div>
                <div class="form-check form-check-custom mb-2">
                    <input class="form-check-input" name="issuecategory[]" type="checkbox" value="Network">
                    <label class="form-check-label fw-semibold ps-2 fs-6">Network</label>
                </div>
                <div class="form-check form-check-custom mb-2">
                    <input class="form-check-input" name="issuecategory[]" type="checkbox" value="User">
                    <label class="form-check-label fw-semibold ps-2 fs-6">User</label>
                </div>
                <!-- End Options -->
            </div>
            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
        </div>
    </div>

    <div class="col-12">
        <!-- Source Report -->
        <div class="mb-3">
            <label class="form-label">Source Report:</label>
            <div class="input-group">
                <livewire:helpdesk::source-report />
            </div>
        </div>
    </div>
</div>
<!--end::Input group-->


                    <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Report Time</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                <span class="symbol-label bg-secondary">
                                    <i class="ki-duotone ki-element-11"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                                    </span>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Datepicker-->
                            <input class="form-control form-control-solid ps-12 flatpickr-input" placeholder="Select a date" name="report_time" id="report_time" type="text">
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Col-->

                    {{-- <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Finish Time</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                <span class="symbol-label bg-secondary">
                                    <i class="ki-duotone ki-element-11"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                                    </span>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Datepicker-->
                            <input class="form-control form-control-solid ps-12 flatpickr-input" placeholder="Select a date" name="finish_date" id="finish_date" type="text" readonly="readonly">
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>
                    <!--end::Col--> --}}
                </div>
                <!--end::Input group-->

                    {{-- <!--begin::Input group-->
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="form-label"><span class="required">Category:</span></label>
                            <select class="form-select form-select-solid" id="category-dropdown" name="category-dropdown" data-control="select2" data-placeholder="Select an option">
                                <option></option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                        </div>
                    </div>
                    <!--end::Input group--> --}}


                </div>
                <!--end::Card body-->

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                        id="kt_new_ticket_cancel">Discard</button>
                    <button type="submit" id="kt_new_ticket_submit" class="btn btn-primary">
                        @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
                    </button>
                </div>
                <!--end::Actions-->
                <input type="hidden">
            </form>
            <!--end::Form-->
        </div>
    </div>
    @endif

    @include('helpdesk::ticket/work_order')
    @include('helpdesk::ticket/work_order_note')


    @push('styles')
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    @endpush
    @push('scripts')
    <!-- Load jQuery from a CDN -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/custom/apps/helpdesk/ticket.js"></script>

    {{-- //TODO:Create single file for WorkOrder JS --}}
    <script>
        // Pass data to JavaScript
        var canCreateTicket = @json($canCreateTicket);
        var isSupervisor = @json($isSupervisor);
        console.log(canCreateTicket);

    $(document).ready(function() {

        // var xButton = document.getElementById('kt_new_ticket_cancel');
        // if (xButton) {
        //     // Add your click event listener here
        //     xButton.addEventListener('click', function () {
        //         e.preventDefault();
        //         // Close kt_docs_card_ticket_new
        //         $('#kt_docs_card_ticket_new').collapse('hide');
        //         // Show kt_docs_card_ticket_list
        //         $('#kt_docs_card_ticket_list').collapse('show');
        //         // dtTicket.ajax.reload();
        //     });
        // }

        var options = {selector: "#description_wo", height : "480"};

        if ( KTThemeMode.getMode() === "dark" ) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);

        $("#report_time").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            maxDate: new Date(), 
        });

            // $('.js-staff-tags').select2({
            //     tags: true,
            //     tokenSeparators: [','],
            // });

            // Initialize Select2
            // var staffSelect = $('#kt_modal_work_order').find('.js-staff-tags');
            // staffSelect.select2({
            //     tags: true,
            //     tokenSeparators: [','],
            // });

            // Reset the form when "Cancel" button is clicked
            $('#kt_new_ticket_cancel').click(function () {
                // $('#kt_modal_new_work_order_form')[0].reset();
                // Close kt_docs_card_ticket_new
                $('#kt_docs_card_ticket_new').collapse('hide');
                // Show kt_docs_card_ticket_list
                $('#kt_docs_card_ticket_list').collapse('show');
                // staffSelect.val(null).trigger('change'); // Reset Select2 tags
            });

            $('.generate-work-order').click(function () {
            // Get the data-id attribute value from the clicked link
            var rowId = $(this).data('id');

            // Assuming you want to set the data-id value to an input field in the modal form
            $('#ticket_id').val(rowId);
            console.log(rowId);

            // Optionally, you can open the modal programmatically if needed
            // $('#kt_modal_work_order').modal('show');

            // Prevent the default link click behavior (optional)
            return false;
        });

            submitButtonWO = document.querySelector('#kt_modal_new_work_order_submit');

            submitButtonNotes = document.querySelector('#kt_modal_work_order_note_submit');
             // Reset the form when "Cancel" button is clicked
             $('#kt_modal_work_order_note_cancel').click(function () {
                $('#kt_modal_work_order_note_form')[0].reset();
                $('#kt_modal_work_order_note').modal('hide');
            });

            // Handle form submission
            $('#kt_modal_new_work_order_form').submit(function (e) {
                e.preventDefault();

                // Get the data-id attribute value from the clicked row
                var rowId = $(this).closest('tr').data('id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/apps/helpdesk/api/workorder',
                        type: 'POST',
                        data: {
                            ticket_id: $('#ticket_id').val(),
                            subject: $('#subject_wo').val(),
                            description: $('#description_wo').val(),
                            due_date: $('#due_date').val(),
                            staff: $('#staffSelect').val(),
                            priority: $('#priority').val(),
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
                                // settingCompanyForm.reset();
                                // validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                                // toggleChangeEmail();
                                // Hide loading indication
                                submitButtonWO.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonWO.disabled = false;

                                $('#ticketTable').DataTable().ajax.reload();

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

                // var assignOptions = [];
                //     $("input[name='issuecategory[]']:checked").each(function () {
                //         assignOptions.push($(this).val());
                //     });

                // subject_wo = $('#subject_wo').val();
                // description_wo = $('#description_wo').val();
                // due_date = $('#due_date').val();
                // staff = $('#staffSelect').val();
                // console.log('form work order submit : '+ subject_wo +'  '+ description_wo +'  '+due_date+'  '+staff);

                // Implement your form submission logic here
                // ...


            });

            // Handle notes form submission
            $('#kt_modal_work_order_note_form').submit(function (e) {
                e.preventDefault();

                // Get the data-id attribute value from the clicked row
                var rowId = $(this).closest('tr').data('id');
                // Get the selected issuecategory options
                var categoryOptions = [];
                    $("input[name='category[]']:checked").each(function () {
                        categoryOptions.push($(this).val());
                    });

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/apps/helpdesk/api/workorder/notes',
                        type: 'POST',
                        data: {
                            ticket_id: $('#ticket_id').val(),
                            notes: $('#notes').val(),
                            category: categoryOptions,
                        },
                        success: function (response) {
                            // Hide loading indication
                            submitButtonNotes.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonNotes.disabled = false;

                            // Reset the form and Select2 tags after submission (if needed)
                            $('#kt_modal_work_order_note_form')[0].reset();
                            // staffSelect.val(null).trigger('change');

                            // Close the modal
                            $('#kt_modal_work_order_note').modal('hide');

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
                                submitButtonNotes.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButtonNotes.disabled = false;

                                $('#ticketTable').DataTable().ajax.reload();

                            });
                        },
                        error: function (xhr) {
                            // Handle errors here
                            // Hide loading indication
                            submitButtonNotes.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButtonNotes.disabled = false;

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
    });
        // submitButton = document.querySelector('#kt_new_ticket_submit');


        $("#due_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });



            $.fn.dataTable.ext.buttons.reload = {
                text: 'Reload',
                action: function ( e, dt, node, config ) {
                    dt.ajax.reload();
                }
            };



    // Assuming you're using jQuery for simplicity
    $('#ticketTable').on('click', '.delete-button', function() {
        var ticketId = $(this).data('id');
        // Show a confirmation dialog if needed
        if (confirm('Are you sure you want to delete this ticket?')) {
            // Send an AJAX request to delete the record
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
                        table.ajax.reload();
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
        }
    });

    // Handle button click events
    $('#ticketTable').on('click', '.view-work-order', function () {
        var id = $(this).data('id');
        // Implement logic to handle "View" button click
        console.log('View work order for ID: ' + id);
    });

    $('#ticketTable').on('click', '.generate-work-order', function () {
        var id = $(this).data('id');
        // Implement logic to handle "Generate Work Order" button click
        console.log('Generate work order for ID: ' + id);
        // Get the data-id attribute value from the clicked link
        var rowId = $(this).data('id');

        fetchStaffData();

        // Assuming you want to set the data-id value to an input field in the modal form
        $('#ticket_id').val(rowId);
        // console.log(rowId);
    });

    $('#ticketTable').on('click', '.generate-notes', function () {
        var id = $(this).data('id');
        // Implement logic to handle "Generate Notes" button click
        console.log('Generate Notes for ID: ' + id);
        // Get the data-id attribute value from the clicked link
        var rowId = $(this).data('id');

        // Assuming you want to set the data-id value to an input field in the modal form
        $('#ticket_id').val(rowId);
        // console.log(rowId);
    });

        // Get all collapsible elements with data-bs-toggle attribute
        const collapsibles = document.querySelectorAll('[data-bs-toggle="collapse"]');

        // Add a click event listener to each collapsible element
        collapsibles.forEach(collapsible => {
            collapsible.addEventListener('click', () => {
                // Get the target element associated with this collapsible
                const targetId = collapsible.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);

                // Check if the target element is currently expanded
                const isExpanded = targetElement.classList.contains('show');

                // Collapse all other collapsible elements
                collapsibles.forEach(otherCollapsible => {
                    if (otherCollapsible !== collapsible) {
                        const otherTargetId = otherCollapsible.getAttribute('data-bs-target');
                        const otherTargetElement = document.querySelector(otherTargetId);

                        // Close the other element if it's expanded
                        if (otherTargetElement.classList.contains('show')) {
                            otherTargetElement.classList.remove('show');
                        }
                    }
                });

                // Expand or collapse the clicked element
                if (!isExpanded) {
                    targetElement.classList.add('show');
                } else {
                    targetElement.classList.remove('show');
                }
            });
        });

        // Handle form submit
        // submitButton.addEventListener('click', function (e) {
        //     e.preventDefault();

        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     $.ajax({
        //         url: '/apps/helpdesk/api/ticket',
        //         type: 'POST',
        //         data: {
        //             subject: $('#subject').val(),
        //             description: $('#description').val(),
        //             reporter_name: $('#reporter-dropdown').val(),
        //             origin_unit: $('#unit-dropdown').val(),
        //             // Include other fields here
        //             // _token: '{{ csrf_token() }}', // CSRF token for Laravel
        //         },
        //         success: function (response) {
        //             // alert(response.message);
        //             // Hide loading indication
        //             submitButton.removeAttribute('data-kt-indicator');

        //             // Enable button
        //             submitButton.disabled = false;

        //             swal.fire({
        //                 text: response.message,
        //                 icon: "success",
        //                 buttonsStyling: false,
        //                 confirmButtonText: "Ok, got it!",
        //                 customClass: {
        //                     confirmButton: "btn font-weight-bold btn-light-primary"
        //                 }
        //             }).then(function(){
        //                 // table.ajax.reload();
        //                 $('#kt_docs_card_ticket_list').collapse('show');
        //                 $('#kt_docs_card_ticket_new').collapse('hide');
        //                 // settingCompanyForm.reset();
        //                 // validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
        //                 // toggleChangeEmail();
        //                 // Hide loading indication
        //                 // submitButton.removeAttribute('data-kt-indicator');

        //                 // Enable button
        //                 // submitButton.disabled = false;
        //             });
        //         },
        //         error: function (xhr) {
        //             // Handle errors here
        //             Swal.fire({
        //                 text: "Sorry, looks like there are some errors detected, please try again.",
        //                 icon: "error",
        //                 buttonsStyling: false,
        //                 confirmButtonText: "Ok, got it!",
        //                 customClass: {
        //                     confirmButton: "btn btn-primary"
        //                 }
        //             });
        //             // Hide loading indication
        //             submitButton.removeAttribute('data-kt-indicator');

        //             // Enable button
        //             submitButton.disabled = false;
        //         }
        //     });

        // });

        // Function to fetch staff data and populate the dropdown
    function fetchStaffData() {
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
        createTag: function (params) {
            return {
                id: params.term,
                text: params.term,
                newTag: true
            };
        }
    });

    </script>
    @endpush

</x-default-layout>
