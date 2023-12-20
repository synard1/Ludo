<p>
    <a href="/apps/helpdesk/print/wo/{{ $workOrder->id }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a><a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 generate-work-order-response" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="{{ $workOrder->id }}" data-subject="{{ $workOrder->subject }}" data-report-time="{{ $workOrder->report_time }}"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>
</p>

{{-- <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 edit-ticket" data-id="{{ $workOrder->id }}">
            Edit
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 delete-row" data-kt-docs-table-filter="delete_row" data-id="{{ $workOrder->id }}">
            Delete
        </a>
    </div>
    <!--end::Menu item-->

    <div class="separator mt-3 opacity-75"></div>
    @if($isSupervisor && $workOrder->status == 'Resolved' || $workOrder->status == 'Closed')
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="/apps/helpdesk/print/wo/{{ $workOrder->id }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a>
            </div>
            <!--end::Menu item-->
    @endif

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 edit-workorder" data-id="{{ $ticket->work_order_id }}">
            Edit WO
        </a>
    </div>
    <!--end::Menu item-->


</div>
<!--end::Menu--> --}}
