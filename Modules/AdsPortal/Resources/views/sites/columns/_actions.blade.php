<!-- <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-adssite-id="{{ $adssite->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_site" data-kt-action="update_row">
    {!! getIcon('setting-3','fs-3') !!}
</button> -->

<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    @can('write ads portal')
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="" class="menu-link px-3" data-adssite-id="{{ $adssite->id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_add_site" data-kt-action="update_row">
            Update
        </a>
    </div>
    <!--end::Menu item-->
    @endcan

    @can('delete ads portal')
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3" data-adssite-id="{{ $adssite->id }}" data-kt-action="delete_row">
            Delete
        </a>
    </div>
    <!--end::Menu item-->
    @endcan
</div>
<!--end::Menu-->
