<x-default-layout>
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                {{-- <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Order" />
                </div>
                <!--end::Search--> --}}
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                {{-- <!--begin::Flatpickr-->
                <div class="input-group w-250px">
                    <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Pick date range" id="kt_ecommerce_sales_flatpickr" />
                    <button class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
                        <i class="ki-duotone ki-cross fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
                <!--end::Flatpickr-->
                <div class="w-100 mw-150px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="status">
                        <option></option>
                        <option value="all">All</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Completed">Completed</option>
                        <option value="Denied">Denied</option>
                        <option value="Expired">Expired</option>
                        <option value="Failed">Failed</option>
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Refunded">Refunded</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Delivering">Delivering</option>
                    </select>
                    <!--end::Select2-->
                </div> --}}

                <!--begin::Add product-->
                <button id="addCategoryBtn" class="btn btn-primary">Add Data</button>
                <!--end::Add product-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="category-table">
                {{-- <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-start w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_sales_table .form-check-input" value="1" />
                            </div>
                        </th>
                        <th class="min-w-100px">Order ID</th>
                        <th class="min-w-175px">Customer</th>
                        <th class="text-end min-w-70px">Status</th>
                        <th class="text-end min-w-100px">Total</th>
                        <th class="text-end min-w-100px">Date Added</th>
                        <th class="text-end min-w-100px">Date Modified</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead> --}}
                {{-- <tbody class="fw-semibold text-gray-600">
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12685</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$229.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-15">
                            <span class="fw-bold">15/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-18">
                            <span class="fw-bold">18/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12686</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-13.jpg" alt="John Miller" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">John Miller</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$297.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-15">
                            <span class="fw-bold">15/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-17">
                            <span class="fw-bold">17/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12687</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-13.jpg" alt="John Miller" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">John Miller</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$261.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-13">
                            <span class="fw-bold">13/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-16">
                            <span class="fw-bold">16/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12688</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-12.jpg" alt="Ana Crown" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ana Crown</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$269.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-08">
                            <span class="fw-bold">08/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-15">
                            <span class="fw-bold">15/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12689</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-info text-info">A</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Robert Doe</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Refunded">
                            <!--begin::Badges-->
                            <div class="badge badge-light-info">Refunded</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$156.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-07">
                            <span class="fw-bold">07/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-14">
                            <span class="fw-bold">14/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12690</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Neil Owen</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$194.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-11">
                            <span class="fw-bold">11/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-13">
                            <span class="fw-bold">13/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12691</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$96.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-10">
                            <span class="fw-bold">10/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-12">
                            <span class="fw-bold">12/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12692</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Denied">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Denied</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$314.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-09">
                            <span class="fw-bold">09/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-11">
                            <span class="fw-bold">11/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12693</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Expired">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Expired</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$286.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-07">
                            <span class="fw-bold">07/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-10">
                            <span class="fw-bold">10/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12694</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-12.jpg" alt="Ana Crown" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ana Crown</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$70.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-04">
                            <span class="fw-bold">04/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-09">
                            <span class="fw-bold">09/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12695</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-success text-success">L</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Lucy Kunic</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$237.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-02">
                            <span class="fw-bold">02/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-08">
                            <span class="fw-bold">08/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12696</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">E</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Bold</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$33.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-01">
                            <span class="fw-bold">01/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-07">
                            <span class="fw-bold">07/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12697</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-12.jpg" alt="Ana Crown" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ana Crown</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$269.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-31">
                            <span class="fw-bold">31/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-06">
                            <span class="fw-bold">06/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12698</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Neil Owen</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$101.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-02">
                            <span class="fw-bold">02/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-05">
                            <span class="fw-bold">05/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12699</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$167.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-29">
                            <span class="fw-bold">29/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-04">
                            <span class="fw-bold">04/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12700</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Processing">
                            <!--begin::Badges-->
                            <div class="badge badge-light-primary">Processing</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$271.00</span>
                        </td>
                        <td class="text-end" data-order="2024-11-02">
                            <span class="fw-bold">02/11/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-03">
                            <span class="fw-bold">03/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12701</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-23.jpg" alt="Dan Wilson" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Dan Wilson</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$377.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-27">
                            <span class="fw-bold">27/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-02">
                            <span class="fw-bold">02/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12702</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Pending">
                            <!--begin::Badges-->
                            <div class="badge badge-light-warning">Pending</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$477.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-27">
                            <span class="fw-bold">27/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-11-01">
                            <span class="fw-bold">01/11/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12703</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Francis Mitcham</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$123.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-29">
                            <span class="fw-bold">29/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-31">
                            <span class="fw-bold">31/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12704</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-1.jpg" alt="Max Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Max Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$298.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-26">
                            <span class="fw-bold">26/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-30">
                            <span class="fw-bold">30/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12705</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Francis Mitcham</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$414.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-27">
                            <span class="fw-bold">27/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-29">
                            <span class="fw-bold">29/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12706</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Cancelled">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Cancelled</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$138.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-22">
                            <span class="fw-bold">22/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-28">
                            <span class="fw-bold">28/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12707</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-12.jpg" alt="Ana Crown" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ana Crown</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Cancelled">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Cancelled</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$143.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-22">
                            <span class="fw-bold">22/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-27">
                            <span class="fw-bold">27/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12708</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$436.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-22">
                            <span class="fw-bold">22/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-26">
                            <span class="fw-bold">26/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12709</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-success text-success">L</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Lucy Kunic</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Pending">
                            <!--begin::Badges-->
                            <div class="badge badge-light-warning">Pending</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$354.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-18">
                            <span class="fw-bold">18/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-25">
                            <span class="fw-bold">25/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12710</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Neil Owen</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$334.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-20">
                            <span class="fw-bold">20/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-24">
                            <span class="fw-bold">24/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12711</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Francis Mitcham</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Refunded">
                            <!--begin::Badges-->
                            <div class="badge badge-light-info">Refunded</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$459.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-21">
                            <span class="fw-bold">21/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-23">
                            <span class="fw-bold">23/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12712</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-success text-success">L</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Lucy Kunic</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$300.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-15">
                            <span class="fw-bold">15/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-22">
                            <span class="fw-bold">22/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12713</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-warning text-warning">C</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Mikaela Collins</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$118.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-14">
                            <span class="fw-bold">14/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-21">
                            <span class="fw-bold">21/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12714</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$238.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-14">
                            <span class="fw-bold">14/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-20">
                            <span class="fw-bold">20/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12715</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-info text-info">A</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Robert Doe</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$461.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-18">
                            <span class="fw-bold">18/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-19">
                            <span class="fw-bold">19/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12716</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$453.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-13">
                            <span class="fw-bold">13/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-18">
                            <span class="fw-bold">18/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12717</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">E</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Bold</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$39.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-11">
                            <span class="fw-bold">11/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-17">
                            <span class="fw-bold">17/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12718</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Expired">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Expired</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$485.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-15">
                            <span class="fw-bold">15/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-16">
                            <span class="fw-bold">16/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12719</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Expired">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Expired</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$262.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-14">
                            <span class="fw-bold">14/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-15">
                            <span class="fw-bold">15/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12720</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-warning text-warning">C</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Mikaela Collins</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Refunded">
                            <!--begin::Badges-->
                            <div class="badge badge-light-info">Refunded</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$277.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-10">
                            <span class="fw-bold">10/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-14">
                            <span class="fw-bold">14/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12721</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-23.jpg" alt="Dan Wilson" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Dan Wilson</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$119.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-10">
                            <span class="fw-bold">10/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-13">
                            <span class="fw-bold">13/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12722</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-25.jpg" alt="Brian Cox" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Brian Cox</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Pending">
                            <!--begin::Badges-->
                            <div class="badge badge-light-warning">Pending</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$267.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-07">
                            <span class="fw-bold">07/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-12">
                            <span class="fw-bold">12/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12723</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Delivered">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Delivered</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$384.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-10">
                            <span class="fw-bold">10/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-11">
                            <span class="fw-bold">11/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12724</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Neil Owen</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$229.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-05">
                            <span class="fw-bold">05/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-10">
                            <span class="fw-bold">10/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12725</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$92.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-02">
                            <span class="fw-bold">02/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-09">
                            <span class="fw-bold">09/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12726</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-9.jpg" alt="Francis Mitcham" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Francis Mitcham</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Cancelled">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Cancelled</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$158.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-01">
                            <span class="fw-bold">01/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-08">
                            <span class="fw-bold">08/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12727</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$173.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-02">
                            <span class="fw-bold">02/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-07">
                            <span class="fw-bold">07/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12728</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-1.jpg" alt="Max Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Max Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$223.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-03">
                            <span class="fw-bold">03/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-06">
                            <span class="fw-bold">06/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12729</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-5.jpg" alt="Sean Bean" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Sean Bean</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$132.00</span>
                        </td>
                        <td class="text-end" data-order="2024-10-03">
                            <span class="fw-bold">03/10/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-05">
                            <span class="fw-bold">05/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12730</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">N</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Neil Owen</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Completed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-success">Completed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$279.00</span>
                        </td>
                        <td class="text-end" data-order="2024-09-29">
                            <span class="fw-bold">29/09/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-04">
                            <span class="fw-bold">04/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12731</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Cancelled">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Cancelled</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$354.00</span>
                        </td>
                        <td class="text-end" data-order="2024-09-28">
                            <span class="fw-bold">28/09/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-03">
                            <span class="fw-bold">03/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12732</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">M</div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Melody Macy</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$39.00</span>
                        </td>
                        <td class="text-end" data-order="2024-09-26">
                            <span class="fw-bold">26/09/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-02">
                            <span class="fw-bold">02/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12733</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-6.jpg" alt="Emma Smith" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Emma Smith</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Failed">
                            <!--begin::Badges-->
                            <div class="badge badge-light-danger">Failed</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$371.00</span>
                        </td>
                        <td class="text-end" data-order="2024-09-24">
                            <span class="fw-bold">24/09/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-10-01">
                            <span class="fw-bold">01/10/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                            <a href="apps/ecommerce/sales/details.html" class="text-gray-800 text-hover-primary fw-bold">12734</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="apps/user-management/users/view.html">
                                        <div class="symbol-label">
                                            <img src="assets/media/avatars/300-21.jpg" alt="Ethan Wilder" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="apps/user-management/users/view.html" class="text-gray-800 text-hover-primary fs-5 fw-bold">Ethan Wilder</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-0" data-order="Delivering">
                            <!--begin::Badges-->
                            <div class="badge badge-light-primary">Delivering</div>
                            <!--end::Badges-->
                        </td>
                        <td class="text-end pe-0">
                            <span class="fw-bold">$100.00</span>
                        </td>
                        <td class="text-end" data-order="2024-09-26">
                            <span class="fw-bold">26/09/2024</span>
                        </td>
                        <td class="text-end" data-order="2024-09-30">
                            <span class="fw-bold">30/09/2024</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/details.html" class="menu-link px-3">View</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="apps/ecommerce/sales/edit-order.html" class="menu-link px-3">Edit</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                </tbody> --}}
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Increase modal size -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCategoryModalLabel">Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="category-id"></span></p>
                    <p><strong>Name:</strong> <span id="category-name"></span></p>
                    <p><strong>Description:</strong> <span id="category-description"></span></p>
                    <p><strong>Created At:</strong> <span id="category-created-at"></span></p>

                    <!-- Asset Types DataTable -->
                    <h5 class="mt-3">Asset Types</h5>
                    <table id="asset-type-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit-category-id">
                        <div class="mb-3">
                            <label for="edit-category-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-category-name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCategoryForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add-category-name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="add-category-name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    @push('scripts')

    <script>
        "use strict";

        // Class definition
        var KTAppEcommerceSalesListing = function () {
            // Shared variables
            var table;
            var datatable, dtButtons;
            var flatpickr;
            var minDate, maxDate;
            var assetTypeTable;


            // Private functions
            var initDatatable = function () {
                // Init datatable --- more info on datatables: https://datatables.net/manual/

                dtButtons = ['reload', 'print', 'colvis'];

                $.fn.dataTable.ext.buttons.reload = {
                    text: 'Reload',
                    action: function(e, dt, node, config) {
                        $('#category-table').DataTable().ajax.reload();
                    }
                };
                datatable = $("#category-table").DataTable({
                    ajax: {
                        url: "/api/v1/itam/category",
                        // data: {
                        //     // task: 'GET_ITAM_CATEGORY',
                        //     response_type: 'json',
                        // },
                    },
                    columns: [
                        {
                            targets: 0,
                            data: null,
                            title: '#',

                            render: function(data, type, row, meta) {
                                // 'meta.row' contains the row number
                                return meta.row + 1;
                            },
                        },
                        {
                            data: 'id'
                        },
                        {
                            data: 'name',
                            title: 'Name',

                        },
                        {
                            data: 'created_at',
                            title: 'Created Date',
                            render: function(data, type, row) {
                                if (type === 'display' || type === 'filter') {
                                    // Format the date using moment.js
                                    return moment(data).format('YYYY-MM-DD HH:mm:ss');
                                }
                                return data; // For sorting and other types
                            }
                        },
                        {
                            data: 'action',
                            title: 'Action',

                        },

                    ],
                    columnDefs: [{
                        targets: [1], // index of the column you want to disable ColVis for (0-based index)
                        visible: false,
                        searchable: false, // optional: hide from search
                    }, ],
                    dom: 'Bfrtip',
                    buttons: dtButtons,

                    // Use the passed data
                });

                // Re-init functions on datatable re-draws
                datatable.on('draw', function () {
                    handleDeleteRows();
                });
            }

            // var initDatatable = function () {
            //     // Init datatable --- more info on datatables: https://datatables.net/manual/
            //     datatable = $(table).DataTable({
            //         "info": false,
            //         'order': [],
            //         'pageLength': 10,
            //         'columnDefs': [
            //             { orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
            //             // { orderable: false, targets: 7 }, // Disable ordering on column 7 (actions)
            //         ]
            //     });

            //     // Re-init functions on datatable re-draws
            //     datatable.on('draw', function () {
            //         handleDeleteRows();
            //     });
            // }

            // Init flatpickr --- more info :https://flatpickr.js.org/getting-started/
            // var initFlatpickr = () => {
            //     const element = document.querySelector('#kt_ecommerce_sales_flatpickr');
            //     flatpickr = $(element).flatpickr({
            //         altInput: true,
            //         altFormat: "d/m/Y",
            //         dateFormat: "Y-m-d",
            //         mode: "range",
            //         onChange: function (selectedDates, dateStr, instance) {
            //             handleFlatpickr(selectedDates, dateStr, instance);
            //         },
            //     });
            // }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            // var handleSearchDatatable = () => {
            //     const filterSearch = document.querySelector('[data-kt-ecommerce-order-filter="search"]');
            //     filterSearch.addEventListener('keyup', function (e) {
            //         datatable.search(e.target.value).draw();
            //     });
            // }

            // Handle status filter dropdown
            // var handleStatusFilter = () => {
            //     const filterStatus = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
            //     $(filterStatus).on('change', e => {
            //         let value = e.target.value;
            //         if (value === 'all') {
            //             value = '';
            //         }
            //         datatable.column(3).search(value).draw();
            //     });
            // }

            // Handle flatpickr --- more info: https://flatpickr.js.org/events/
            // var handleFlatpickr = (selectedDates, dateStr, instance) => {
            //     minDate = selectedDates[0] ? new Date(selectedDates[0]) : null;
            //     maxDate = selectedDates[1] ? new Date(selectedDates[1]) : null;

            //     // Datatable date filter --- more info: https://datatables.net/extensions/datetime/examples/integration/datatables.html
            //     // Custom filtering function which will search data in column four between two values
            //     $.fn.dataTable.ext.search.push(
            //         function (settings, data, dataIndex) {
            //             var min = minDate;
            //             var max = maxDate;
            //             var dateAdded = new Date(moment($(data[3]).text(), 'DD/MM/YYYY'));
            //             var dateModified = new Date(moment($(data[3]).text(), 'DD/MM/YYYY'));

            //             if (
            //                 (min === null && max === null) ||
            //                 (min === null && max >= dateModified) ||
            //                 (min <= dateAdded && max === null) ||
            //                 (min <= dateAdded && max >= dateModified)
            //             ) {
            //                 return true;
            //             }
            //             return false;
            //         }
            //     );
            //     datatable.draw();
            // }

            // Handle clear flatpickr
            // var handleClearFlatpickr = () => {
            //     const clearButton = document.querySelector('#kt_ecommerce_sales_flatpickr_clear');
            //     clearButton.addEventListener('click', e => {
            //         flatpickr.clear();
            //     });
            // }

            // Delete cateogry
            var handleDeleteRows = () => {
                $('#category-table').on('click', '[data-filter="delete_row"]', function (e) {
                    e.preventDefault();

                    var button = $(this);
                    var parentRow = button.closest('tr');
                    var dataTitle = parentRow.find('td:eq(1)').text(); // Get category name
                    var categoryId = button.data('id'); // Ensure the button has 'data-id' attribute

                    Swal.fire({
                        text: `Are you sure you want to delete category: ${dataTitle}?`,
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform AJAX delete request
                            $.ajax({
                                url: `/api/v1/itam/category/${categoryId}`,
                                type: "DELETE",
                                success: function(response) {
                                    Swal.fire({
                                        text: `Category "${dataTitle}" has been deleted!`,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary"
                                        }
                                    }).then(() => {
                                        $('#category-table').DataTable().row(parentRow).remove().draw(); // Remove row from DataTable
                                    });
                                },
                                error: function(xhr) {
                                    let errorMessage = xhr.responseJSON?.error || "Failed to delete category.";

                                    Swal.fire({
                                        text: errorMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });
                        }
                    });
                });
            };


            // Function to handle the View button
            var handleViewCategory = () => {
                $('#category-table').on('click', '.view-category', function() {
                    var categoryId = $(this).data('id').trim();


                    $.ajax({
                        url: "/api/v1/itam/category",
                        type: "GET",
                        data: { task: "GET_ITAM_CATEGORY", id: categoryId },
                        success: function(response) {
                            $('#category-id').text(response.id);
                            $('#category-name').text(response.name);
                            $('#category-description').text(response.description);
                            $('#category-created-at').text(moment(response.created_at).format('YYYY-MM-DD HH:mm:ss'));

                            // Destroy DataTable if already initialized
                            if($.fn.DataTable.isDataTable('#asset-type-table')) {
                                assetTypeTable.destroy();
                            }

                            // Initialize DataTable
                            assetTypeTable = $('#asset-type-table').DataTable({
                                data: response.asset_types,
                                columns: [
                                    { data: null, render: (data, type, row, meta) => meta.row + 1 }, // Auto-increment
                                    { data: 'id' },
                                    { data: 'name' }
                                ]
                            });

                            $('#viewCategoryModal').modal('show'); // Show modal
                        },
                        error: function() {
                            Swal.fire("Error!", "Failed to fetch category details.", "error");
                        }
                    });
                });
            };

            var handleEditCategory = () => {
                $('#category-table').on('click', '.edit-category', function () {
                    var categoryId = $(this).data('id').trim();

                    $.ajax({
                        url: `/api/v1/itam/category/${categoryId}/edit`,
                        type: "GET",
                        success: function (response) {
                            // Populate modal with category data
                            $('#edit-category-id').val(response.id);
                            $('#edit-category-name').val(response.name);

                            // Show modal
                            $('#editCategoryModal').modal('show');
                        },
                        error: function () {
                            Swal.fire("Error!", "Failed to fetch category details.", "error");
                        }
                    });
                });

                $('#editCategoryForm').submit(function (e) {
                    e.preventDefault();

                    var categoryId = $('#edit-category-id').val();
                    var categoryName = $('#edit-category-name').val();

                    $.ajax({
                        url: `/api/v1/itam/category/${categoryId}`,
                        type: "PUT",
                        data: {
                            name: categoryName,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            Swal.fire("Success!", response.message, "success");

                            $('#editCategoryModal').modal('hide'); // Close modal

                            $('#category-table').DataTable().ajax.reload(); // Reload DataTable
                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON?.error || "Failed to update category.";
                            Swal.fire("Error!", errorMessage, "error");
                        }
                    });
                });
            };

            var handleAddCategory = () => {
                $('#addCategoryBtn').on('click', function () {
                    $('#addCategoryModal').modal('show'); // Show the Add Category Modal
                });


                $('#addCategoryForm').submit(function (e) {
                    e.preventDefault();

                    var categoryName = $('#add-category-name').val();

                    $.ajax({
                        url: "/api/v1/itam/category",
                        type: "POST",
                        data: {
                            name: categoryName,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            Swal.fire("Success!", response.message, "success");

                            $('#addCategoryModal').modal('hide'); // Close modal
                            $('#addCategoryForm')[0].reset(); // Reset form fields

                            $('#category-table').DataTable().ajax.reload(); // Reload DataTable
                        },
                        error: function (xhr) {
                            let errorMessage = xhr.responseJSON?.error || "Failed to add category.";
                            Swal.fire("Error!", errorMessage, "error");
                        }
                    });
                });
            };




            // Public methods
            return {
                init: function () {
                    table = document.querySelector('#category-table');

                    if (!table) {
                        return;
                    }

                    initDatatable();
                    // initFlatpickr();
                    // handleSearchDatatable();
                    // handleStatusFilter();
                    handleDeleteRows();
                    handleViewCategory();
                    handleEditCategory();
                    handleAddCategory();

                    // handleClearFlatpickr();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTAppEcommerceSalesListing.init();
        });

    </script>
        
    @endpush
</x-default-layout>