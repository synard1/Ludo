    <!--begin::Card-->
    <div class="card card-flush mb-6 mb-xl-12">
        <!--begin::Card header-->
        <div class="card-header pt-5">
        <!--begin::Card title-->
        <div class="card-title">
        </div>
        <!--end::Card title-->
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
        {{ $dataTable->scripts() }}
    @endpush