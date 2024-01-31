@if(auth()->check())
    @php
        $user = auth()->user();
		foreach(auth()->user()->roles as $role){
			$roleId	=	$role->id;
		}

		if($user->status == "Active"){
			$isActive = true;
		}else{
			$isActive = false;
		}

    @endphp
@endif

<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
            <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
				<div class="menu-item {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
						<span class="menu-title">Dashboards</span>
					</span>

					<!--end:Menu link-->
				</div>
			</a>
			<!--end:Menu item-->

			@if($isActive)
				<!--begin:Menu item-->
				<div class="menu-item pt-5">
					<!--begin:Menu content-->
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7">Apps</span>
					</div>
					<!--end:Menu content-->
				</div>
				<!--end:Menu item-->
				@if(App\Helpers\ModuleHelper::isModuleActive('ITSM'))
					@if(auth()->user()->can('access itsm'))
						@include('itsm::layouts.partials.sidebar.menu')
					@endif
				@endif
				@if(App\Helpers\ModuleHelper::isModuleActive('AdsPortal'))
					@if(auth()->user()->can('access ads portal'))
						@include('adsportal::layouts.partials.sidebar.menu')
					@endif
				@endif
				@if(App\Helpers\ModuleHelper::isModuleActive('Hotspot'))
					@if(auth()->user()->can('access hotspot'))
						@include('hotspot::layouts.partials.sidebar.menu')
					@endif
				@endif
				@if(App\Helpers\ModuleHelper::isModuleActive('Helpdesk'))
					@if(auth()->user()->can('access helpdesk') || auth()->user()->can('read helpdesk'))
						@include('helpdesk::layouts.partials.sidebar.menu')
					@endif
				@endif
				@if(App\Helpers\ModuleHelper::isModuleActive('SLA'))
					@if(auth()->user()->can('access sla') || auth()->user()->can('read sla'))
						@include('sla::layouts.partials.sidebar.menu')
					@endif
				@endif
			@endif

            @if(auth()->check() && auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Administrator'))
			<!--begin:Menu item-->
			<div class="menu-item pt-5">
				<!--begin:Menu content-->
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Administration</span>
				</div>
				<!--end:Menu content-->
			</div>
			<!--end:Menu item-->

			@if($isActive)
			<!--begin:Menu item-->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('profile-circle', 'fs-2') !!}</span>
					<span class="menu-title">User Management</span>
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
							<span class="menu-title">Users</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
                            @can('read user management')
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link {{ request()->routeIs('user-management.users.index') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Users List</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
                            @endcan
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link {{ request()->routeIs('user-management.users.show') ? 'active' : '' }}" href="{{ route('user-management.users.show', auth()->id()) }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">User Profile</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					@can('read role management')
						<!-- The user has the Super Admin role -->
						<!--begin:Menu item-->
						<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.roles.*') ? 'here show' : '' }}">
							<!--begin:Menu link-->
							<span class="menu-link">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Roles</span>
								<span class="menu-arrow"></span>
							</span>
							<!--end:Menu link-->
							<!--begin:Menu sub-->
							<div class="menu-sub menu-sub-accordion">
								<!--begin:Menu item-->
								<div class="menu-item">
									<!--begin:Menu link-->
									<a class="menu-link {{ request()->routeIs('user-management.roles.index') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Roles List</span>
									</a>
									<!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								<!--begin:Menu item-->
								<div class="menu-item">
									<!--begin:Menu link-->
									<a class="menu-link {{ request()->routeIs('user-management.roles.show') ? 'active' : '' }}" href="{{ route('user-management.roles.show', $roleId) }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">View Role</span>
									</a>
									<!--end:Menu link-->
								</div>
								<!--end:Menu item-->
							</div>
							<!--end:Menu sub-->
						</div>
						<!--end:Menu item-->
						<!-- Your code here -->
					@endcan
					@can('read permission management')
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.permissions.*') ? 'here show' : '' }}">
							<!--begin:Menu link-->
							<span class="menu-link">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Permission</span>
								<span class="menu-arrow"></span>
							</span>
							<!--end:Menu link-->
							<!--begin:Menu sub-->
							<div class="menu-sub menu-sub-accordion">
								<!--begin:Menu item-->
								<div class="menu-item">
									<!--begin:Menu link-->
									<a class="menu-link {{ request()->routeIs('user-management.permissions.UserShow') ? 'active' : '' }}" href="{{ route('user-management.permissions.UserShow') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Permission User List</span>
									</a>
									<!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								<!--begin:Menu item-->
								<div class="menu-item">
									<!--begin:Menu link-->
									<!-- <a class="menu-link {{ request()->routeIs('user-management.permissions.show') ? 'active' : '' }}" href="{{ route('user-management.permissions.show', $roleId) }}"> -->
									<a class="menu-link {{ request()->routeIs('user-management.permissions.index') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">View Permission</span>
									</a>
									<!--end:Menu link-->
								</div>
								<!--end:Menu item-->
							</div>
							<!--end:Menu sub-->
						</div>
						<!--end:Menu item-->
					<!--begin:Menu item-->
					@endcan



				</div>
				<!--end:Menu sub-->
			</div>
			<!--end:Menu item-->
			@endif
			
			<!--begin:Menu item-->
			<div class="menu-item {{ request()->routeIs('settings.*') ? 'here show' : '' }}">
                <a class="menu-link {{ request()->routeIs('settings.index') ? 'active' : '' }}" href="{{ route('settings.index') }}">
				<!--begin:Menu link-->
					<span class="menu-icon">{!! getIcon('gear', 'fs-2') !!}</span>
					<span class="menu-title">Settings</span>
				<!--end:Menu link-->
                </a>
			</div>
			<!--end:Menu item-->
			@endif
			@if(auth()->check() && auth()->user()->hasRole('Super Admin'))
			<!--begin:Menu item-->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('system.*') || request()->routeIs('semver.*') ? 'here show' : '' }}">
				<!--begin:Menu link-->
				<span class="menu-link">
					<span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
					<span class="menu-title">System</span>
					<span class="menu-arrow"></span>
				</span>
				<!--end:Menu link-->
				<!--begin:Menu sub-->
				<div class="menu-sub menu-sub-accordion">
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion mb-1 {{ request()->routeIs('system.logs.*') ? 'here show' : '' }}">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-bullet">
								<span class="bullet bullet-dot"></span>
							</span>
							<span class="menu-title">Logs</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link {{ request()->routeIs('system.audit-logs.index') ? 'active' : '' }}" href="{{ route('system.audit-logs.index') }}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Audit Logs</span>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
				</div>
				<!--end:Menu sub-->
				@if(App\Helpers\ModuleHelper::isModuleActive('Semver'))
					@if(auth()->user()->can('access semver'))
						@include('semver::layouts.partials.sidebar.menu')
					@endif
				@endif
			</div>
			<!--end:Menu item-->
			@endif
			@if(auth()->check() && auth()->user()->hasRole('Super Admin'))
			<!--begin:Menu item-->
			<div class="menu-item pt-5">
				<!--begin:Menu content-->
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Help</span>
				</div>
				<!--end:Menu content-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
			<div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link" href="https://preview.keenthemes.com/laravel/metronic/docs/base/utilities" target="_blank">
					<span class="menu-icon">{!! getIcon('rocket', 'fs-2') !!}</span>
					<span class="menu-title">Components</span>
				</a>
				<!--end:Menu link-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
			<div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link" href="https://preview.keenthemes.com/laravel/metronic/docs" target="_blank">
					<span class="menu-icon">{!! getIcon('abstract-26', 'fs-2') !!}</span>
					<span class="menu-title">Documentation</span>
				</a>
				<!--end:Menu link-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
			<div class="menu-item">
				<!--begin:Menu link-->
				<a class="menu-link" href="https://preview.keenthemes.com/laravel/metronic/docs/changelog" target="_blank">
					<span class="menu-icon">{!! getIcon('code', 'fs-2') !!}</span>
					<span class="menu-title">Changelog v8.1.9</span>
				</a>
				<!--end:Menu link-->
			</div>
			<!--end:Menu item-->
			@endif
		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
