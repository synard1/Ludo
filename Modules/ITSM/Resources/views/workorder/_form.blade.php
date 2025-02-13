{{-- //TODO: Make Form Validation --}}
<div class="modal fade" tabindex="-1" id="kt_modal_work_order">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form id="kt_modal_new_work_order_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" data-select2-id="select2-data-kt_modal_new_work_order_form">
                    <input type="hidden" class="form-control form-control-solid" name="data_id" id="data_id" readonly>
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Create Work Order</h1>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="text-gray-500 fw-semibold fs-5">
                            If you need more info, please check <a href="" class="fw-bold link-primary">Support Guidelines</a>.
                        </div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Subject</span>
                        </label>
                        <!--end::Label-->

                        <input type="text" class="form-control form-control-solid" name="titleWorkOrder" id="titleWorkOrder" readonly>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2">Description</label>

                        <textarea class="form-control form-control-solid" rows="4" name="description_wo" id="description_wo"></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Assign</label>
                        <select id="staffSelect" name="staffSelect" class="js-staff-tags form-control" multiple="multiple" placeholder="Enter / Select Staff">
                            <option value="">=== Assign Staff ===</option>
                            @foreach ($distinctStaff as $staff)
                                <option value="{{ $staff }}">{{ $staff }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->

                    @if($sla->isEmpty())
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Due Date</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                <span class="symbol-label bg-secondary">
                                    <i class="ki-duotone ki-element-11"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                                    </span>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Datepicker-->
                            <input class="form-control form-control-solid ps-12 flatpickr-input" placeholder="Select a date" name="due_date" id="due_date" type="text">
                            <!--end::Datepicker-->
                        </div>
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Col-->
                    @else
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">SLA</label>

                        <!--begin::Input-->
                        <div class="position-relative d-flex align-items-center">

                            <select id="sla" name="sla" class="js-select2 form-control">
                                <option value="">Select SLA</option>
                                @foreach ($sla as $slas)
                                    <option value="{{ $slas->id }}">{{ $slas->name }}</option>
                                @endforeach
                        </select>
                        </div>
                        <!--end::Input-->
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Col-->
                    @endif
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row g-9 mb-8">
                    <!--begin::Col-->
                    <div class="col-md-6 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Priority</label>
                        <select id="priority" name="priority" class="js-priority form-control" placeholder="Enter / Select Priority">
                            <option value="" selected>-- Select Priority --</option>
                            @foreach ($priorities as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_new_ticket_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" id="kt_modal_new_work_order_submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
