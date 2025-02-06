{{--
    //TODO: Make Form Validation
--}}
<div class="modal fade" tabindex="-1" id="kt_modal_work_order_response">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form id="kt_modal_work_order_response_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#" data-select2-id="select2-data-kt_modal_work_order_response_form">
                    {{-- <input type="hidden" id="workorder_id" name="workorder_id"> --}}
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Response Work Order</h1>
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
                            <span class="required">Subject :</span>
                        </label>
                        <!--end::Label-->

                        <input type="text" class="form-control form-control-solid" name="workorder_subject" id="workorder_subject" readonly>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <div class="col-sm-6 fv-row">
                            <label for="report_time_input" class="form-label">Report Time</label>
                            <div class="input-group log-event" id="report_time" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                <input id="report_time_input"  name="report_time"  type="text" class="form-control" data-td-target="#report_time" readonly/>
                                <span class="input-group-text" data-td-target="#report_time" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 fv-row">
                            <label for="response_time_input" class="form-label">Response Time</label>
                            <div class="input-group log-event" id="response_time" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                <input id="response_time_input" name="response_time" type="text" class="form-control" data-td-target="#response_time" readonly/>
                                <span class="input-group-text" data-td-target="#response_time" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <div class="col-sm-6 fv-row">
                            <label for="start_time_input" class="form-label">From</label>
                            <div class="input-group log-event" id="start_time" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                <input id="start_time_input"  name="start_time"  type="text" class="form-control" data-td-target="#start_time"/>
                                <span class="input-group-text" data-td-target="#start_time" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 fv-row">
                            <label for="finish_time_input" class="form-label">To</label>
                            <div class="input-group log-event" id="finish_time" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                <input id="finish_time_input" name="finish_time" type="text" class="form-control" data-td-target="#finish_time"/>
                                <span class="input-group-text" data-td-target="#finish_time" data-td-toggle="datetimepicker">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Status</label>
                            <select id="status" name="status" class="js-status form-control" placeholder="Enter / Select Status">
                                <option value="">=== Select Status ===</option>
                                @foreach ($statusWorkOrder as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Description</label>

                        <textarea class="form-control form-control-solid" rows="2" name="description_response" id="description_response"> </textarea>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <!--end::Input group-->


                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_work_order_response_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" id="kt_modal_work_order_response_submit" class="btn btn-primary">
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

@push('scripts')
    {{-- <script>
        $(document).ready(function() {
            // var reportTime = new Date();
            // var reportTime = new Date($(this).data('report-time'));
            // console.log(reportTime);
            

            // const linkedPicker1Element = document.getElementById("start_time");
            // const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
            // const linked2 = new tempusDominus.TempusDominus(document.getElementById("finish_time"), {
            //     useCurrent: false,
            // });

            // linked1.updateOptions({
            //         restrictions: {
            //             minDate: reportTime,
            //         },
            //     });

            // //using event listeners
            // linkedPicker1Element.addEventListener(tempusDominus.Namespace.events.change, (e) => {
            //     linked2.updateOptions({
            //         restrictions: {
            //         minDate: e.detail.date,
            //         },
            //     });
            // });

            // //using subscribe method
            // const subscription = linked2.subscribe(tempusDominus.Namespace.events.change, (e) => {
            //     linked1.updateOptions({
            //         restrictions: {
            //         maxDate: e.date,
            //         },
            //     });
            // });
        });
    </script> --}}

@endpush
