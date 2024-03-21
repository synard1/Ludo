@php
    $user = auth()->user(); 
    $mode = session('mode', ''); // Retrieve the mode from session
@endphp

@if ($canCreateLogbook)
<div class="card shadow-sm mb-5">
    <div class="card-header collapsible cursor-pointer rotate">
        <h3 class="card-title" id="logbookTitleForm">New Log</h3>
        <div class="card-toolbar rotate-180">
            <i class="ki-duotone ki-down fs-1"></i>
        </div>
    </div>
    <div id="kt_docs_card_logbook_new" class="collapse">
        <!--begin::Form-->
        <form id="kt_new_logbook_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                            <label class="required fs-6 fw-semibold mb-2">Title</label>

                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Enter title" name="title" id="title">
                            </div>
                            <!--end::Input-->
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>
                </div>
                <!--end::Input group-->

                @if ($user->level_access == 'Supervisor')
                
                    <div class="edit-status" id="edit-status" style="display: none;">
                        <!--begin::Input group-->
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-6 fw-semibold mb-2">Status</label>
                                <select id="status" name="status" class="js-status form-control" placeholder="Enter / Select Status">
                                    <option value="" selected>-- Select Status --</option>
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                @endif
                

                <!--begin::Input group-->
                <div class="row mb-2">
                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2 required">
                            Description
                        </label>
                        <!--end::Label-->

                        <textarea class="form-control form-control-solid" name="description" id="description"></textarea>
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
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

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2 btn-cancel"
                    id="kt_new_logbook_cancel">Discard</button>
                <button type="submit" id="kt_new_logbook_submit" class="btn btn-primary">
                    @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
                </button>
            </div>
            <!--end::Actions-->
            <input type="hidden">
        </form>
        <!--end::Form-->
    </div>
</div>
@endif