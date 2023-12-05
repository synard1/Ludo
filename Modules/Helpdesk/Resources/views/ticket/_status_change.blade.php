<div class="modal fade" tabindex="-1" id="kt_modal_change_status">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form id="kt_modal_change_status_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" data-select2-id="select2-data-kt_modal_change_status_form">
                    <input type="hidden" id="ticket_id" name="ticket_id">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Change Status</h1>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="text-gray-500 fw-semibold fs-5">
                            If you need more info, please check <a href="" class="fw-bold link-primary">Support Guidelines</a>.
                        </div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Old Status</label>
                            <input type="text" class="form-control form-control-solid" name="old_status" id="old_status" readonly>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">New Status</label>
                            <select id="status" name="status" class="js-status form-control" placeholder="Enter / Select Status">
                                <option value="" selected>-- Select New Status --</option>
                                @foreach ($statusTicket as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Reason</label>

                        <textarea class="form-control form-control-solid" rows="2" name="reason" id="reason"></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->


                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_change_status_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" id="kt_modal_change_status_submit" class="btn btn-primary">
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
