@extends('adsportal::layouts.app')

@section('content')
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
	<!--begin::Page-->
	<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
		<!--begin::Header-->
		<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
			<!--begin::Header container-->
			<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
				<!--begin::Header mobile toggle-->
				<div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
					<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
						<i class="ki-outline ki-abstract-14 fs-2"></i>
					</div>
				</div>
				<!--end::Header mobile toggle-->
				<!--begin::Logo-->
				<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-13">
					<a href="#">
						<!-- <img alt="Logo" src="/assets/media/logos/demo41.svg" class="h-25px" /> -->
						<img alt="Logo" src="{{ asset('assets/media/logos/demo41.svg') }}" class="h-25px" />
					</a>
				</div>
				<!--end::Logo-->
				<!--begin::Header wrapper-->
				<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
					<!--begin::Menu wrapper-->
					<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
						<!--begin::Menu-->
						<div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
								<!--begin:Menu link-->
								<span class="menu-link">
									<span class="menu-title">{{ $data->sites }}</span>
									<span class="menu-arrow d-lg-none"></span>
								</span>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
							<!--begin:Menu item-->
							<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
								<!--begin:Menu link-->
								<!-- <span id="time" style="font-size: 28px;"></span> -->
								<span class="menu-arrow d-lg-none"></span>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end::Menu-->
					</div>
					<!--end::Menu wrapper-->
					<div class="app-navbar flex-shrink-0">
						<!--begin::Notifications-->
						<div class="app-navbar-item ms-1 ms-lg-3">
							<!--begin::Menu- wrapper-->
							<span id="time" style="font-size: 28px;"></span>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Notifications-->
					</div>
				</div>
				<!--end::Header wrapper-->
			</div>
			<!--end::Header container-->
		</div>
		<!--end::Header-->
		<!--begin::Wrapper-->
		<div class="app-wrapper d-flex" id="kt_app_wrapper">
			<!--begin::Main-->
			<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
				<!--begin::Content wrapper-->
				<div class="d-flex flex-column flex-column-fluid">

					<!--begin::Content-->
					<div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
						<!--begin::Card-->
						<div class="card card-flush" id="kt_docs_content_card">
							<!--begin::Card Body-->
							<div class="card-body">

								<!--begin::Section-->
								<div class="pt-1">
									<div class="rounded border p-5 p-lg-1">
										<div class="tns tns-default" style="direction: ltr">
											<!--begin::Slider-->
											<div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="3000" data-tns-autoplay="true" data-tns-autoplay-timeout="10000" data-tns-controls="false" data-tns-nav="false" data-tns-items="1" data-tns-center="true" data-tns-dots="false">

												<!--begin::Item-->
												<div class="text-center px-5 py-5">
													<img src="/assets/media/stock/900x600/1.jpg" class="card-rounded mw-100" alt="" />
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="text-center px-5 py-5">
													<img src="/assets/media/stock/900x600/2.jpg" class="card-rounded mw-100" alt="" />
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="text-center px-5 py-5">
													<img src="/assets/media/stock/900x600/3.jpg" class="card-rounded mw-100" alt="" />
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="text-center px-5 py-5">
													<img src="/assets/media/stock/900x600/4.jpg" class="card-rounded mw-100" alt="" />
												</div>
												<!--end::Item-->
												<!--begin::Item-->
												<div class="text-center px-5 py-5">
													<img src="/assets/media/stock/900x600/5.jpg" class="card-rounded mw-100" alt="" />
												</div>
												<!--end::Item-->

											</div>
											<!--end::Slider-->
										</div>
									</div>
								</div>
								<!--end::Section-->
							</div>
							<!--end::Card Body-->
							<div class="py-5 text-center">
								<!--begin::Information-->
								<div class="d-flex align-items-center rounded py-5 px-5 bg-light-info "><i class="ki-duotone ki-delivery-24 fs-3x text-information me-5"><i class="path1"></i>
										<i class="path2"></i>
										<i class="path3"></i>
										<i class="path4"></i></i> <!--begin::Description-->
									<div class="text-gray-700 fw-bold fs-6 text-center">
										Informasi Pemasangan Iklan, hubungi <code>PT ABC</code> Telp. <code>0811223344</code>&nbsp;
									</div> <!--end::Description-->
								</div><!--end::Information-->
							</div>
						</div>
						<!--end::Card-->
					</div>
					<!--end::Content-->

				</div>
				<!--end::Content wrapper-->
				<!--begin::Footer-->
				<div id="kt_app_footer" class="app-footer">
					<!--begin::Footer container-->
					<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
						<!--begin::Copyright-->
						<div class="text-dark order-2 order-md-1">
							<span class="text-muted fw-semibold me-1">2023&copy;</span>
							<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
						</div>
						<!--end::Copyright-->
						<!--begin::Menu-->
						<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
							<li class="menu-item">
								<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
							</li>
							<li class="menu-item">
								<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
							</li>
							<li class="menu-item">
								<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
							</li>
						</ul>
						<!--end::Menu-->
					</div>
					<!--end::Footer container-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end:::Main-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
</div>
<!--end::App-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->
<!--begin::Modals-->
<!--end::Modals-->
<!--begin::Javascript-->
<script>
	var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="/assets/js/widgets.bundle.js"></script>
<script src="/assets/js/custom/widgets.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
// </body>
<!--end::Body-->
@endsection