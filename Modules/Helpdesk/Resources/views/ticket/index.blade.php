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
                <table id="ticketTable" class="display responsive nowrap table table-striped table-row-bordered gy-5 gs-7"
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
    @if ($canCreateTicket)
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

                                <textarea class="form-control form-control-solid" name="description" id="description"> </textarea>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-2">
                            <div class="col fv-row">
                                <label for="" class="form-label"><span class="required">Unit:</span></label>
                                <div class="input-group">
                                    <livewire:helpdesk::unit-select />
                                </div>
                            </div>
                            <div class="col fv-row">
                                <label for="" class="form-label">User:</label>
                                <div class="input-group">
                                    <livewire:helpdesk::reporter-select />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-4">
                            <div class="col-12 fv-row">
                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label required fw-semibold fs-6">Category</label>
                                    <div class="d-flex flex-column">
                                        <!-- Options -->
                                        <div class="form-check form-check-custom mb-2">
                                            <input class="form-check-input" name="issuecategory[]" type="checkbox"
                                                value="Hardware">
                                            <label class="form-check-label fw-semibold ps-2 fs-6">Hardware</label>
                                        </div>
                                        <div class="form-check form-check-custom mb-2">
                                            <input class="form-check-input" name="issuecategory[]" type="checkbox"
                                                value="Software">
                                            <label class="form-check-label fw-semibold ps-2 fs-6">Software</label>
                                        </div>
                                        <div class="form-check form-check-custom mb-2">
                                            <input class="form-check-input" name="issuecategory[]" type="checkbox"
                                                value="Disaster">
                                            <label class="form-check-label fw-semibold ps-2 fs-6">Disaster</label>
                                        </div>
                                        <div class="form-check form-check-custom mb-2">
                                            <input class="form-check-input" name="issuecategory[]" type="checkbox"
                                                value="Network">
                                            <label class="form-check-label fw-semibold ps-2 fs-6">Network</label>
                                        </div>
                                        <div class="form-check form-check-custom mb-2">
                                            <input class="form-check-input" name="issuecategory[]" type="checkbox"
                                                value="User">
                                            <label class="form-check-label fw-semibold ps-2 fs-6">User</label>
                                        </div>
                                        <!-- End Options -->
                                    </div>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 fv-row">
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
                                            <i class="ki-duotone ki-element-11"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span></i> </span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Datepicker-->
                                    <input class="form-control form-control-solid ps-12 flatpickr-input"
                                        placeholder="Select a date" name="report_time" id="report_time"
                                        type="text">
                                    <!--end::Datepicker-->
                                </div>
                                <!--end::Input-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Col-->

                            {{--
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                            <label class="required fs-6 fw-semibold mb-2">Finish Time</label>

                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                    <span class="symbol-label bg-secondary">
                                        <i class="ki-duotone ki-element-11"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i> </span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Datepicker-->
                                <input class="form-control form-control-solid ps-12 flatpickr-input"
                                    placeholder="Select a date" name="finish_date" id="finish_date" type="text"
                                    readonly="readonly">
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                        <!--end::Col--> --}}
                        </div>
                        <!--end::Input group-->

                        {{--
                    <!--begin::Input group-->
                    <div class="row mb-2">
                        <div class="col">
                            <label for="" class="form-label"><span class="required">Category:</span></label>
                            <select class="form-select form-select-solid" id="category-dropdown"
                                name="category-dropdown" data-control="select2" data-placeholder="Select an option">
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
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
        <script src="/assets/js/custom/apps/helpdesk/ticket.js"></script>

        <script>
            // Pass data to JavaScript
            var canCreateTicket = @json($canCreateTicket);
            var isSupervisor = @json($isSupervisor);

            $(document).ready(function() {
                
                

            });
        </script>
    @endpush

</x-default-layout>
