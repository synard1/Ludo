<!--begin:Menu item-->
<div data-kt-menu-trigger="click"
    class="menu-item menu-accordion {{ request()->routeIs('helpdesk.*') ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">{!! getIcon('support-24', 'fs-2') !!}</span>
        <span class="menu-title">Helpdesk</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('helpdesk.tickets') ? 'active' : '' }}"
                href="{{ route('helpdesk.tickets') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Ticket</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->

    @if(auth()->check() && auth()->user()->level_access === 'Owner')
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('helpdesk.service-management') ? 'active' : '' }}"
                href="{{ route('helpdesk.service-management') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Service Management</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
    @endif

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('helpdesk.workorder') ? 'active' : '' }}"
                href="{{ route('helpdesk.workorder') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Work Order</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
