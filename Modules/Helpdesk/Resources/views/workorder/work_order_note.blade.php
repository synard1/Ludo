{{--
    //TODO: Make Form Validation
--}}
<div class="modal fade" tabindex="-1" id="kt_modal_work_order_note">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form id="kt_modal_work_order_note_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" data-select2-id="select2-data-kt_modal_work_order_note_form">
                    <input type="hidden" id="ticket_id" name="ticket_id">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Notes Work Order</h1>
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
                        <label class="required fs-6 fw-semibold mb-2">Notes</label>

                        <textarea class="form-control form-control-solid" rows="2" name="notes" id="notes"> </textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label
                            class="col-lg-4 col-form-label required fw-semibold fs-6">Category</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <!--begin::Options-->
                            <div class="d-flex align-items-center mt-3">
                                <!--begin::Option-->
                                <label
                                    class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="issuecategory[]"
                                        type="checkbox" value="Hardware" >
                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                                    Hardware
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label
                                    class="form-check form-check-custom form-check-inline form-check-solid">
                                    <input class="form-check-input" name="issuecategory[]"
                                        type="checkbox" value="Software" >
                                                                                                <span class="fw-semibold ps-2 fs-6">
                                        Software
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label
                                    class="form-check form-check-custom form-check-inline form-check-solid">
                                    <input class="form-check-input" name="issuecategory[]"
                                        type="checkbox" value="Disaster" >
                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                                    Disaster
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label
                                    class="form-check form-check-custom form-check-inline form-check-solid">
                                    <input class="form-check-input" name="issuecategory[]"
                                        type="checkbox" value="Network" >
                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                                    Network
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                <label
                                    class="form-check form-check-custom form-check-inline form-check-solid">
                                    <input class="form-check-input" name="issuecategory[]"
                                        type="checkbox" value="User" >
                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                                                                    User
                                    </span>
                                </label>
                                <!--end::Option-->
                            </div>
                            <!--end::Options-->
                            <div
                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->


                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_work_order_note_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" id="kt_modal_work_order_note_submit" class="btn btn-primary">
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
