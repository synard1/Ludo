<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">SLA List</h3>
            @if($canCreateSla)
            <div class="card-toolbar">
                <!--begin::Menu-->
                <button type="button" class="btn btn-primary" id="kt_new_sla">
                    <i class="ki-duotone ki-plus fs-2"></i> New SLA
                </button>
                <!--end::Menu-->
            </div>
            @endif
        </div>
        <div id="kt_docs_card_sla_list" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
        </div>
    </div>

    @if ($canCreateSla)
        <div class="card shadow-sm mb-5">
            <div class="card-header collapsible cursor-pointer rotate">
                <h3 class="card-title" id="slaFormTitle">New SLA</h3>
                <div class="card-toolbar rotate-180">
                    <i class="ki-duotone ki-down fs-1"></i>
                </div>
            </div>
            <div id="kt_docs_card_sla_new" class="collapse">
                <!--begin::Form-->
                <form id="kt_new_sla_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                    novalidate="novalidate">
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Input group-->
                        <div class="row mb-2">
                            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                    <span class="required">SLA Title</span>
                                </label>
                                <!--end::Label-->

                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Enter your sla name" name="title" id="title">
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
                                    <span class="required">SLA Description</span>
                                </label>
                                <!--end::Label-->

                                <textarea class="form-control form-control-solid" name="description" id="description"></textarea>
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
                                    <span class="required">Duration</span>
                                </label>
                                <!--end::Label-->

                                <input type="number" 
                                        min="0"
                                        class="form-control form-control-solid"
                                    placeholder="Enter sla duration" name="duration" id="duration">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                                <span>In Minutes</span>
                            </div>
                        </div>
                        <!--end::Input group-->


                    </div>
                    <!--end::Card body-->

                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                            id="kt_new_sla_cancel">Discard</button>
                        <button type="submit" id="kt_new_sla_submit" class="btn btn-primary">
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

    {{-- <script>
        var newSlaButton = document.querySelector('#kt_new_sla');
        // Add a click event listener to the "New Ticket" button
        newSlaButton.addEventListener('click', function (e) {
            // form = document.querySelector('#kt_new_sla_form');
            // form.reset();
            e.preventDefault();

            // Change the title text when the button is clicked
            slaTitle.innerText = 'New SLA';

            // Find the input element by its id
            var titleInput = document.getElementById('title');
            titleInput.removeAttribute('readonly');


            // Close kt_docs_card_sla_new
            $('#kt_docs_card_sla_new').collapse('show');
            // Show kt_docs_card_sla_list
            $('#kt_docs_card_sla_list').collapse('hide');
        });
    </script> --}}
    @endpush

</x-default-layout>
