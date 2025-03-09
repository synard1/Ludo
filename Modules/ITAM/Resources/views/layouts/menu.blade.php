<!--begin:Menu item-->
<div data-kt-menu-trigger="click"
    class="menu-item menu-accordion {{ request()->routeIs('itam.*') ? 'here show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link">
        <span class="menu-icon">{!! getIcon('monitor-mobile', 'fs-2') !!}</span>
        <span class="menu-title">ITAM</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    @if(auth()->user()->can('read itam asset'))

    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item">
            <!--begin:Menu link-->
            <a class="menu-link {{ request()->routeIs('itam.asset') ? 'active' : '' }}"
                href="{{ route('itam.asset') }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Asset Management</span>
            </a>
            <!--end:Menu link-->
        </div>
        <!--end:Menu item-->
    </div>
    <!--end:Menu sub-->
    @endif
</div>
<!--end:Menu item-->
