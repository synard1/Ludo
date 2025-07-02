<x-default-layout>
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                    href="#kt_service_overview">Overview</a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_service_general">General
                    Settings</a>
            </li>
            <!--end:::Tab item-->
        </ul>
        <!--end:::Tabs-->
        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="kt_service_overview" role="tabpanel">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Service Request List</h2>
                        </div>
                        <!--end::Card title-->
                        @if($canCreateService)
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-primary" id="kt_new_service">
                                <i class="ki-duotone ki-plus fs-2"></i> Make Service Request
                            </button>
                            <!--end::Menu-->
                        </div>
                        @endif
                    </div>
                    <!--end::Card header-->
                    <div id="kt_docs_card_service_list" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table-->
                            {{-- {{ $serviceDataTable->table() }} --}}
                            <!-- For Service DataTable -->
                            <div class="datatable-container">
                                {{ $dataTable->table() }}
                            </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                @include('itsm::service._form')
                <!--end::Card-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="kt_service_general" role="tabpanel">
                <!--begin::Card-->
                @include('itsm::service/_category')
                <!--end::Card-->
            </div>
            <!--end:::Tab pane-->
        </div>
        <!--end:::Tab content-->
    </div>
    <!--end::Content-->

    @include('itsm::workorder/_form')

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{ $dataTable->scripts() }}

    <script>
        // Pass data to JavaScript
        var canCreateService = @json($canCreateService);
        var canCreateServiceCategory = @json($canCreateServiceCategory);
        var isSupervisor = @json($isSupervisor);
        var slaExist = true;
        
        // Inisialisasi jam kerja dari config backend
        window.workingHours = @json(config('itsm.working_hours'));

        $(document).ready(function () {
            // Attach a click event handler to the tab links
            $('.nav-link').on('shown.bs.tab', function (e) {
                // Log the tab that has been shown
                // console.log('Tab shown:', e.target.href);

                 // Check if the clicked tab has the id kt_service_general
                if (e.target.href.includes('#kt_service_general')) {
                    // Show an alert when kt_service_general tab is clicked
                    // alert('kt_service_general tab clicked');
                    getServiceCategory();
                }
            });
        });
    </script>
    @endpush

</x-default-layout>