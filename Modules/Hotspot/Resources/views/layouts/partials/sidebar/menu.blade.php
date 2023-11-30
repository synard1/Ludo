<!--begin:Menu item-->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('hotspot.*') ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">{!! getIcon('wifi', 'fs-2') !!}</span>
        <span class="menu-title">Hotspot Portal</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 {{ request()->routeIs('user-management.users.*') ? 'here show' : '' }}">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Ads</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
