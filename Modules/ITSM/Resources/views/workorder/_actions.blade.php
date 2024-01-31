<!--begin::Menu-->
<p>
    {{-- <!--begin::Menu item-->
    <a href="/apps/itsm/print/wo/{{ $workorder->id }}" target="_blank" 
        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <i class="ki-duotone ki-printer fs-2">
            <span class="path1"></span><span class="path2"></span>
        </i>
    </a>
    <!--end::Menu item--> --}}

    @if($workorder->status != 'Completed' && $workorder->status != 'Closed')
        <!--begin::Menu item-->
        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 generate-work-order-response"
            data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="{{ $workorder->id }}"
            data-subject="{{ $workorder->subject }}" data-report-time="{{ $workorder->report_time }}">
            <i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i>
        </a>
        <!--end::Menu item-->
    @endif
</p>
<!--end::Menu-->

@push('scripts')

    
@endpush