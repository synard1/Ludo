<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Version History</h3>
            @if($canCreateVersion)
            <div class="card-toolbar">
                <!--begin::Menu-->
                <button type="button" class="btn btn-primary" id="kt_new_version">
                    <i class="ki-duotone ki-plus fs-2"></i> New Version
                </button>
                <!--end::Menu-->
            </div>
            @endif
        </div>
        <div id="kt_docs_card_version_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>
    </div>
    @if ($canCreateVersion)
        <div class="card shadow-sm mb-5">
            <div class="card-header collapsible cursor-pointer rotate">
                <h3 class="card-title" id="versionTitle">New Version</h3>
                <div class="card-toolbar rotate-180">
                    <i class="ki-duotone ki-down fs-1"></i>
                </div>
            </div>
            <div id="kt_docs_card_version_new" class="collapse">
                <!--begin::Form-->
                <form id="kt_new_version_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
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
                                    placeholder="Enter your version subject" name="subject" id="subject">
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
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Release Data</span>

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
                                        placeholder="Select a date" name="release_date" id="release_date"
                                        type="text">
                                    <!--end::Datepicker-->
                                </div>
                                <!--end::Input-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Col-->

                            <div class="col-6 fv-row">
                                <!-- Source Report -->
                                <div class="mb-3">
                                    <label class="form-label">Release Type:</label>
                                    <div class="input-group">
                                        <select id="sourcesReport" name="sourcesReport" class="js-select2 form-control">
                                            <option value="">Select Release Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <select id="priority" name="priority" class="js-priority form-control" placeholder="Enter / Select Status">
                                    <option value="" selected>-- Select Status --</option>
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                    </div>
                    <!--end::Card body-->

                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                            id="kt_new_version_cancel">Discard</button>
                        <button type="submit" id="kt_new_version_submit" class="btn btn-primary">
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
        var newVersionButton = document.querySelector('#kt_new_version');
        var xButton = document.querySelector('#kt_new_version_cancel');

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

        // // Add a click event listener to the "Cancel" button
        xButton.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset();
            // Close kt_docs_card_version_new
            $('#kt_docs_card_version_new').collapse('hide');
            // Show kt_docs_card_version_list
            $('#kt_docs_card_version_list').collapse('show');
            $("#versions-table").DataTable().ajax.reload(null, false); 
        });
    </script>
    @endpush

</x-default-layout>
