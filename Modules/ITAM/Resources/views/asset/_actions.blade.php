<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    @if($asset->status != 'Completed' && $asset->status != 'Closed')
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 edit-asset" data-id="{{ $asset->id }}">
            Edit
        </a>
    </div>
    <!--end::Menu item-->

    
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 delete-row" data-kt-docs-table-filter="delete_row" data-id="{{ $asset->id }}">
            Delete
        </a>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 details-asset" data-id="{{ $asset->id }}" data-kt-action="details_asset">
            👁️ View Details
        </a>
    </div>
    <!--end::Menu item-->
    @endif

    <div class="separator my-2"></div>

    <!--begin::Menu item-->
    <div class="menu-item px-2">
        <a href="#" class="menu-link px-2 add-spesification" data-id="{{ $asset->id }}" data-kt-action="add_specification">
            Spesification
        </a>
    </div>
    <!--end::Menu item-->



</div>
<!--end::Menu-->
