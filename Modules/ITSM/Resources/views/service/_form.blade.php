@if ($canCreateService)
<div class="card shadow-sm mb-5">
    <div class="card-header collapsible cursor-pointer rotate">
        <h3 class="card-title" id="serviceTitleForm">New Service Request</h3>
        <div class="card-toolbar rotate-180">
            <i class="ki-duotone ki-down fs-1"></i>
        </div>
    </div>
    <div id="kt_docs_card_service_new" class="collapse">
        <!--begin::Form-->
        <form id="kt_new_service_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Service Category</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">

                            <select id="classification" name="classification" class="js-select2 form-control">
                                <option value="">=== Select Service Category ===</option>
                                @foreach ($serviceCategory as $category)
                                <option value="{{ $category->id }}"><b>{{ $category->name }}</b> -- {{
                                    $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input-->
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Service Title</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">
                            <input type="text" class="form-control form-control-solid" placeholder="Enter service title"
                                name="service" id="service">
                        </div>
                        <!--end::Input-->
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
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">
                            Description
                        </label>
                        <!--end::Label-->

                        <textarea class="form-control form-control-solid" name="description"
                            id="description"></textarea>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="col fv-row">
                        <label for="" class="form-label"><span class="required">Location :</span></label>
                        <div class="input-group">
                            {{--
                            <livewire:helpdesk::unit-select /> --}}
                            <livewire:itsm::location />
                        </div>
                    </div>
                    <div class="col fv-row">
                        <label for="" class="form-label">Reported By:</label>
                        <div class="input-group">
                            <livewire:itsm::reported-user />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="required">Report Time</span>

                            <span class="m2-1" data-bs-toggle="tooltip" title="User Report Time">
                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                        </label>
                        <!--end::Label-->

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
                                placeholder="Select a date" name="report_time" id="report_time" type="text">
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="required">Response Time</span>

                            <span class="m2-1" data-bs-toggle="tooltip" title="Staff Response Time">
                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </span>
                        </label>
                        <!--end::Label-->

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
                                placeholder="Select a date" name="response_time" id="response_time" type="text">
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-4">
                    <div class="col-3 fv-row">
                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label required fw-semibold fs-6">Category</label>
                            <div class="d-flex flex-column">
                                <!-- Options -->
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="Hardware">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">Hardware</label>
                                </div>
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="Software">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">Software</label>
                                </div>
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="Disaster">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">Disaster</label>
                                </div>
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="Network">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">Network</label>
                                </div>
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="User">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">User</label>
                                </div>
                                <div class="form-check form-check-custom mb-2">
                                    <input class="form-check-input" name="category[]" type="checkbox" value="HIS">
                                    <label class="form-check-label fw-semibold ps-2 fs-6">HIS</label>
                                </div>
                                <!-- End Options -->
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>

                    <div class="col-4 fv-row">
                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-6">KPI</label>
                            <div class="d-flex flex-row">
                                <!-- Use flex-row to align items horizontally -->
                                <!-- Option Yes -->
                                <div class="form-check me-3">
                                    <!-- Add margin-right to create space between options -->
                                    <input class="form-check-input" type="radio" id="kpi" name="kpi" value="1" checked>
                                    <label class="form-check-label" for="countKpiYes">Yes</label>
                                </div>

                                <!-- Option No -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="kpi" name="kpi" value="0">
                                    <label class="form-check-label" for="countKpiNo">No</label>
                                </div>
                            </div>
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>

                    <div class="col-5 fv-row">
                        <!-- Source Report -->
                        <div class="mb-3">
                            <label class="form-label required">Report Source :</label>
                            <div class="input-group">
                                <livewire:itsm::reported-source />
                            </div>
                        </div>
                    </div>



                </div>
                <!--end::Input group-->

                {{--
                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Severity</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">

                            <select id="severity" name="severity" class="js-select2 form-control">
                                <option value="">=== Select Service Severity ===</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <!--end::Input-->
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                </div>
                <!--end::Input group--> --}}

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                    id="kt_new_service_cancel">Discard</button>
                <button type="submit" id="kt_new_service_submit" class="btn btn-primary">
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

{{-- @push('scripts')
<script>
    // Ambil jam kerja dari backend (config/itsm.php)
// window.workingHours = @json(config('itsm.working_hours'));
//
// function isOutsideWorkingHours(timeStr) {
//     ...
// }
//
// $(document).ready(function() {
//     $('#kt_new_service_form').on('submit', function(e) {
//         ...
//     });
// });
</script>
@endpush --}}