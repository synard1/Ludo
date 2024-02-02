<x-default-layout>
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_incident_overview">Overview</a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_incident_general">General Settings</a>
            </li>
            <!--end:::Tab item-->
        </ul>
        <!--end:::Tabs-->
        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="kt_incident_overview" role="tabpanel">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Incident Report List</h2>
                        </div>
                        <!--end::Card title-->
                        @if($canCreateIncident)
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-primary" id="kt_new_incident">
                                <i class="ki-duotone ki-plus fs-2"></i> Make Incident Report
                            </button>
                            <!--end::Menu-->
                        </div>
                        @endif
                    </div>
                    <!--end::Card header-->
                    <div id="kt_docs_card_incident_list" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table-->
                            {{-- {{ $incidentDataTable->table() }} --}}
                            <!-- For Incident DataTable -->
                    <div class="datatable-container">
                        {{ $dataTable->table() }}
                    </div>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                @include('itsm::incident._form')
                <!--end::Card-->
            </div>
            <!--end:::Tab pane-->
            <!--begin:::Tab pane-->
            <div class="tab-pane fade" id="kt_incident_general" role="tabpanel">
                <!--begin::Card-->
                @include('itsm::incident/_category')
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
    
    {{ $dataTable->scripts() }}

    <script>
        // Pass data to JavaScript
        var canCreateIncident = @json($canCreateIncident);
        var canCreateIncidentCategory = @json($canCreateIncidentCategory);
        var slaExist = @json($sla);


        $(document).ready(function () {
            // Attach a click event handler to the tab links
            $('.nav-link').on('shown.bs.tab', function (e) {
                // Log the tab that has been shown
                // console.log('Tab shown:', e.target.href);

                 // Check if the clicked tab has the id kt_incident_general
                if (e.target.href.includes('#kt_incident_general')) {
                    // Show an alert when kt_incident_general tab is clicked
                    // alert('kt_incident_general tab clicked');
                    getIncidentCategory();
                }
            });
        });

        $('#incidents-table').on('click', '.view-wo', function(e) {
            e.preventDefault();
            const parent = e.target.closest('tr');

            // Get subject name
            // const workorderNumber = parent.querySelectorAll('td')[2].innerText;
            const workorderNumber = $(this).data('number');
            var outputType = "PRINT";
            // var number = workorderNumber;

            $.ajax({
                    // url: '/apps/itsm/api/workorder',
                    // url: '/apps/itsm/api/workorder/' + workorderId,
                    url: '/apps/itsm/api/workorder',
                    type: 'POST',
                    data: {
                        number: workorderNumber,
                        task: 'WORK_ORDER_PRINT',
                        outputType: outputType,
                    },
                    success: function(result) {
                        console.log(workorderNumber);
                        if(result == '1'){
                            window.open('./print/wo/WorkOrder_'+workorderNumber+'.html?random='+new Date().getTime(),'workorder','height=600,width=800,resizable=1,scrollbars=1, menubar=0');
                        }else{
                            console.log('Error');
                        }
                    }
                });
        });
    </script>
    @endpush

</x-default-layout>
