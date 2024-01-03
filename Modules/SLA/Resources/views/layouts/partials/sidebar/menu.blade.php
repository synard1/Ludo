<!--begin:Menu item-->
<div data-kt-menu-trigger="click"
    class="menu-item menu-accordion {{ request()->routeIs('sla.*') ? 'here show' : '' }}">
    <a class="menu-link {{ request()->routeIs('sla.index') ? 'active' : '' }}" href="{{ route('sla.index') }}">
        <!--begin:Menu link-->
            <span class="menu-icon">{!! getIcon('watch', 'fs-2') !!}</span>
            <span class="menu-title">SLA</span>
        <!--end:Menu link-->
        </a>
    <!--begin:Menu sub-->
    {{-- <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('sla.tickets') ? 'active' : '' }}"
                href="{{ route('sla.tickets') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Ticket</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div> --}}
    <!--end:Menu sub-->
    <!--begin:Menu sub-->
    {{-- <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('sla.workorder') ? 'active' : '' }}"
                href="{{ route('sla.workorder') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Work Order</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div> --}}
    <!--end:Menu sub-->
</div>
<!--end:Menu item-->
