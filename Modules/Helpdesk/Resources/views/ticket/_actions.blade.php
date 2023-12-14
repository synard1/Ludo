<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 edit-row" data-kt-docs-table-filter="edit_row" data-id="{{ $ticket->id }}">
            Edit
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 delete-row" data-kt-docs-table-filter="delete_row" data-id="{{ $ticket->id }}">
            Delete
        </a>
    </div>
    <!--end::Menu item-->

    <div class="separator mt-3 opacity-75"></div>

    <!--begin::Menu item-->
    <div class="menu-item px-2">
        <a href="#" class="menu-link px-2 edit-workorder" data-id="{{ $ticket->work_order_id }}">
            Edit Workorder
        </a>
    </div>
    <!--end::Menu item-->

</div>
<!--end::Menu-->
