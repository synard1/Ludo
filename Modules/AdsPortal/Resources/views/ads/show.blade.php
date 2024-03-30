@php

if(request()->routeIs('adsportal.adsportal.ads-image')){
$adsType = 'image';
}else{
$adsType = 'video';
}

@endphp

<x-default-layout>
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
                    @if($adsType == 'video')
                    <button type="button" class="btn btn-light-primary" data-ads-type="{{ $adsType }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_ads">
                        {!! getIcon('plus-square','fs-3') !!}
                        Add New Video Ads
                    </button>
                    @else
                    <button type="button" class="btn btn-light-primary" data-ads-type="{{ $adsType }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_ads_image">
                        {!! getIcon('plus-square','fs-3') !!}
                        Add New Image Ads
                    </button>
                    @endif
                </div>
                <!--end::Toolbar-->
                @endcan
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
    <livewire:adsportal::adss />
    <livewire:adsportal::ads-sched />
    <livewire:adsportal::ads-image />
    @include('adsportal::test.modal-table')


    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('success', function() {
                $('#kt_modal_add_ads').modal('hide');
                $('#kt_modal_add_ads_image').modal('hide');
                window.LaravelDataTables['ads-table'].ajax.reload();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var adsId = '';

            $('#adsScheduleModal').on('shown.bs.modal', function(e) {
                // $('#schedule-table').DataTable().ajax.reload();
                adsId = $(e.relatedTarget).data('ads-id');

                $('#schedule-table').DataTable().destroy();
                load_data(adsId);

                console.log(adsId);
            });



        });



        function load_data(adsId) {
            $('#schedule-table').DataTable({
                processing: true,
                responsive: true,
                // ajax: "/apps/adsportal/getads",
                // data:{adsId:adsId},
                // dataSrc: '',
                ajax: {
                    url: "/apps/adsportal/getads",
                    data: function(d) {
                        d.adsId = adsId; // Replace with the actual value or method to get the value
                    }
                },
                dataSrc: '',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id',
                    },
                    {
                        data: 'client_id',
                        name: 'client_id'
                    },
                    {
                        data: 'ads_id',
                        name: 'ads_id'
                    },
                    {
                        data: 'site_id',
                        name: 'site_id'
                    },
                    {
                        data: 'ads_time',
                        name: 'ads_time'
                    },
                    {
                        data: 'days',
                        name: 'days'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at'
                    // },
                    // {
                    //     data: 'updated_at',
                    //     name: 'updated_at'
                    // }
                ]
            });
        }
    </script>

    {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>