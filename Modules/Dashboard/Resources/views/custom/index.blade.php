@php
    if($company){
        $jsonData = json_decode($company->payload, true);
        $mttrValue = $jsonData['mttr'] ?? Config::get('onexolution.dashboard.mttr');
        $artValue = $jsonData['art'] ?? Config::get('onexolution.dashboard.art');
        $arthValue = $jsonData['arth'] ?? Config::get('onexolution.dashboard.arth');

    }else{
        $mttrValue = Config::get('onexolution.dashboard.mttr');
        $artValue =  Config::get('onexolution.dashboard.art');
        $arthValue =  Config::get('onexolution.dashboard.arth');
    }

@endphp

<x-default-layout>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6">
            <!--begin::Card widget 15-->
            <div class="card card-flush h-xl-100">
                <!--begin::Body-->
                <div class="card-body py-9">
                    @include('dashboard::custom/response_time_report')
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 15-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xxl-6">
            <!--begin::Card widget 15-->
            <div class="card card-flush h-xl-100">
                <!--begin::Body-->
                <div class="card-body py-9">
                    @include('dashboard::custom/resolve_time_hn_report')
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 15-->
        </div>
        <!--end::Col-->

    </div>
    @push('scripts')

    @endpush

</x-default-layout>