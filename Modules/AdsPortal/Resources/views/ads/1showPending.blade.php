<x-default-layout>
    <!--begin::Card-->
    <div class="card card-flush mb-6 mb-xl-12">
        <!--begin::Card header-->
        <div class="card-header pt-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-adspending-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Ads" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            {{ $dataTable->table() }}
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>

    <!--end::Content container-->

    @push('scripts')
    <script src="/assets/js/custom/apps/ads-portal/ads/list/adspendingadmin-table.js"></script>
    <script>
        $(document).ready(function() {
            $('#custom-search-for-datatables').submit(function() {
                let tables = $.fn.dataTable.tables(true); // get all visible DT instances
                $(tables).search($(this).find(input).val()).draw();
            });
        });
    </script>

    {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>