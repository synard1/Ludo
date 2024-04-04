<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Service Request List</h3>
            @if($canCreateService)
            <div class="card-toolbar">
                <!--begin::Menu-->
                <button type="button" class="btn btn-primary" id="kt_new_service">
                    <i class="ki-duotone ki-plus fs-2"></i> New Service Request
                </button>
                <!--end::Menu-->
            </div>
            @endif
        </div>
        <div id="kt_docs_card_service_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>
    </div>
    @if ($canCreateService)
        <div class="card shadow-sm mb-5">
            <div class="card-header collapsible cursor-pointer rotate">
                <h3 class="card-title" id="serviceTitle">New Service Request</h3>
                <div class="card-toolbar rotate-180">
                    <i class="ki-duotone ki-down fs-1"></i>
                </div>
            </div>
            <div id="kt_docs_card_service_new" class="collapse">
                <!--begin::Form-->
                <form id="kt_new_service_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    novalidate="novalidate">
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Input group-->
                        <div class="row mb-2">
                            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                    <label class="required fs-6 fw-semibold mb-2">Service Category</label>

                                    <!--begin::Input-->
                                    <div class="position-relative d-flex align-items-center">

                                        <select id="service" name="service" class="js-select2 form-control">
                                            <option value="">Select Service Category</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"><b>{{ $service->name }}</b> -- {{ $service->description }}</option>
                                            @endforeach
                                    </select>
                                    </div>
                                    <!--end::Input-->
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
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
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Request Time</span>

                                    <span class="m2-1" data-bs-toggle="tooltip"
                                        title="User Report Time">
                                        <i class="ki-duotone ki-information fs-7"><span
                                                class="path1"></span><span class="path2"></span><span
                                                class="path3"></span></i>
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

                        </div>
                        <!--end::Input group-->

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

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{ $dataTable->scripts() }}

    <script>
        // Pass data to JavaScript
        var canCreateService = @json($canCreateService);
        var isSupervisor = @json($isSupervisor);
        var slaExist = true;
    </script>
    @endpush

</x-default-layout>
