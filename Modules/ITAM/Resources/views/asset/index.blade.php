<x-default-layout>
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tabs-->
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                    href="#kt_asset_overview">Overview</a>
            </li>
            <!--end:::Tab item-->
            <!--begin:::Tab item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_asset_category">Asset
                    Category</a>
            </li>
            <!--end:::Tab item-->
        </ul>
        <!--end:::Tabs-->
        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div class="tab-pane fade show active" id="kt_asset_overview" role="tabpanel">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->

                        <div class="card-title">
                            <h3 class="card-title" id="assetTitle">Asset List</h3>

                        </div>

                        @can('create itam asset')
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-primary" id="kt_new_asset">
                                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_asset"> --}}
                                    <i class="ki-duotone ki-plus fs-2"></i> Add Asset
                                </button>
                                <!--end::Menu-->

                                <!--begin::Menu-->
                                <button type="button" class="btn btn-primary" id="kt_view_asset">
                                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_new_asset"> --}}
                                        <i class="ki-duotone ki-eye">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i> View Asset
                                    </button>
                                    <!--end::Menu-->
                        </div>
                        @endcan

                    </div>
                    <!--end::Card header-->
                    <div id="kt_docs_card_asset_list" class="collapse show">
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
                {{-- @include('itam::asset._form') --}}
                <livewire:itam::add-asset />
                <livewire:itam::add-asset-spesification />
                <livewire:itam::view-asset-spesification />

            </div>
            <!--end::Card-->
        </div>
        <!--end:::Tab pane-->
        <!--begin:::Tab pane-->
        <div class="tab-pane fade" id="kt_asset_category" role="tabpanel">
            <!--begin::Card-->
            <!--end::Card-->
        </div>
        <!--end:::Tab pane-->
    </div>
    <!--end:::Tab content-->
    </div>
    <!--end::Content-->

    {{--
    <livewire:itam::add-asset /> --}}

    @push('styles')
        <style>
            .card-header {
    background-color: #f0f0f0; /* Light grey background */
    padding: 10px 15px; /* Consistent padding */
    border-bottom: 1px solid #ddd; /* Add a subtle bottom border */
    display: flex; /* Use flexbox for alignment */
    align-items: center; /* Vertically align items */
}

.card-header h6 {
    margin: 0; /* Remove default margin */
    font-weight: 600; /* Slightly bolder font weight */
    font-size: 16px; /* Consistent font size */
    color: #333; /* Dark grey text */
}

.card-header svg {
    width: 20px; /* Consistent icon size */
    height: 20px;
    margin-right: 10px; /* Spacing between icon and text */
    fill: #333; /* Match icon color to text */
}
            </style>
    @endpush
    

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    {{ $dataTable->scripts() }}

    <script>
        var  newAssetButton = document.querySelector('#kt_new_asset');
        var  newAssetButton = document.querySelector('#kt_new_asset');
        incidentTitleForm = document.getElementById('incidentTitleForm');

        const viewButtons = document.getElementById('kt_view_asset');
        const addButtons = document.getElementById('kt_new_asset');

        viewButtons.style.display = 'none'; // Or button.style.visibility = 'hidden';


        // viewButtons.remove();
        // addButtons.add();

        


        // Add a click event listener to the "New Incident" button
        newAssetButton.addEventListener('click', function (e) {
            form = document.querySelector('#kt_new_asset_form');
            form.reset();
            e.preventDefault();


            // Change the title text when the button is clicked
            // incidentTitleForm.innerText = 'New Incident';

            // Find the input element by its id
            // var incidentInput = document.getElementById('incident');
            // incidentInput.removeAttribute('readonly');


            // Close kt_docs_card_incident_new
            $('#kt_docs_card_asset_new').collapse('show');
            // Show kt_docs_card_incident_list
            $('#kt_docs_card_asset_list').collapse('hide');
        });

        // Add a click event listener to the "New Incident" button
        viewButtons.addEventListener('click', function (e) {
            e.preventDefault();

            addButtons.style.display = ''; // Or button.style.visibility = 'hidden';
            viewButtons.style.display = 'none'; // Or button.style.visibility = 'hidden';

            // Change the title text when the button is clicked
            assetTitle.innerText = 'Asset List';


            // Close kt_docs_card_incident_new
            $('#kt_docs_card_asset_list').collapse('show');
            // Show kt_docs_card_incident_list
            $('#kt_docs_card_asset_new').collapse('hide');
            $('#kt_docs_card_asset_spesification').collapse('hide');
        });

        // document.addEventListener('DOMContentLoaded', function () {
        //     const viewButtons = document.getElementById('kt_view_asset');
        //     viewButtons.remove();

        // });


        

        // Livewire.on('consoleLog', data => console.log(data));

    </script>
    @endpush

</x-default-layout>