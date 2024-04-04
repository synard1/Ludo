{{-- //TODO: Make Form Validation --}}
<div class="modal fade" tabindex="-1" id="kt_modal_category">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form id="kt_modal_new_category_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" data-select2-id="select2-data-kt_modal_new_category_form">
                    {{-- <input type="hidden" class="form-control form-control-solid" name="data_id" id="data_id" readonly> --}}
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3" id="categoryTitleForm">Create Category</h1>
                        <!--end::Title-->

                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Title</span>
                        </label>
                        <!--end::Label-->

                        <input type="text" class="form-control form-control-solid" name="title" id="title" readonly>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold mb-2">Description</label>

                        <textarea class="form-control form-control-solid" rows="4" name="description_category" id="description_category"></textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->


                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_new_category_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" id="kt_modal_new_category_submit" class="btn btn-primary">
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
