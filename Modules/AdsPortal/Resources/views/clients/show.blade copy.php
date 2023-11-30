<x-default-layout>

    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-12">
                <!--begin::Card-->
                <div class="card card-flush mb-6 mb-xl-12">
                    <!--begin::Card header-->
                    <div class="card-header pt-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
            <div class="card-toolbar">
                @can('create ads portal')
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_site">
                        {!! getIcon('plus-square','fs-3') !!}
                        Add Site
                    </button>
                </div>
                <!--end::Toolbar-->
                @endcan
            </div>
            <!--end::Card toolbar-->
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
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Content container-->
    <livewire:adsportal::add-sites />
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>
