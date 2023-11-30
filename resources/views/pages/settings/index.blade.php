<x-default-layout>
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
            <div class="py-5">
                <div class="rounded border p-10">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7" aria-selected="true"
                                role="tab">Company Profile</a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8" aria-selected="false"
                                tabindex="-1" role="tab">Link 2</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_9" aria-selected="false"
                                tabindex="-1" role="tab">Link 3</a>
                        </li>
                        <li class="nav-item dropdown" role="presentation">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" data-bs-toggle="tab" href="#kt_tab_pane_10"
                                        aria-selected="false" tabindex="-1" role="tab">Action</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="tab" href="#kt_tab_pane_11"
                                        aria-selected="false" tabindex="-1" role="tab">Another action</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="tab" href="#kt_tab_pane_12"
                                        aria-selected="false" tabindex="-1" role="tab">Something else here</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="tab" href="#kt_tab_pane_13"
                                        aria-selected="false" tabindex="-1" role="tab">Separated link</a></li>
                            </ul>
                        </li> --}}
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                            <!--begin::Form-->
                            <form id="kt_company_profile_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                novalidate="novalidate">
                                <!--begin::Card body-->
                                <div class="card-body p-9">
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url(/assets/media/avatars/300-1.jpg)">
                                                </div>
                                                <!--end::Preview existing avatar-->

                                                <!--begin::Label-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-pencil fs-7"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                    <input type="hidden" name="avatar_remove">
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Label-->

                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </span>
                                                <!--end::Cancel-->

                                                <!--begin::Remove-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->

                                            <!--begin::Hint-->
                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Company</span>

                                            <span class="m2-1" data-bs-toggle="tooltip"
                                                title="Your company name">
                                                <i class="ki-duotone ki-information fs-7"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="company" id="company"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Company name" value="{{ $company ? $company->name : '' }}">
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Contact Phone</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="tel" name="phone" id="phone"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Phone number" value="{{ $company ? $company->phone : '' }}">
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Company Address</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="address" id="address"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Company address" value="{{ $company ? $company->address : '' }}">
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Site</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="website" id="website"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Company website" value="{{ $company ? $company->website : '' }}">
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Company Email</span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" name="email" id="email"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Company email" value="{{ $company ? $company->email : '' }}">
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label
                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Communication</label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <!--begin::Options-->
                                            <div class="d-flex align-items-center mt-3">
                                                <!--begin::Option-->
                                                <label
                                                    class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                                    <input class="form-check-input" name="communication[]"
                                                        type="checkbox" value="Email"
                                                        {{ in_array('Email', $company->communication ?? []) ? 'checked' : '' }}
                                                        >
                                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                        Email
                                                    </span>
                                                </label>
                                                <!--end::Option-->

                                                <!--begin::Option-->
                                                <label
                                                    class="form-check form-check-custom form-check-inline form-check-solid">
                                                    <input class="form-check-input" name="communication[]"
                                                        type="checkbox" value="Phone"
                                                        {{ in_array('Phone', $company->communication ?? []) ? 'checked' : '' }}
                                                        >
                                                                                                                <span class="fw-semibold ps-2 fs-6">
                                                        Phone
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <!--end::Options-->
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-0">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Allow
                                            Marketing</label>
                                        <!--begin::Label-->

                                        <!--begin::Label-->
                                        <div class="col-lg-8 d-flex align-items-center">
                                            <div
                                                class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                                    id="allowmarketing" checked="" readonly disabled>
                                                <label class="form-check-label" for="allowmarketing"></label>
                                            </div>
                                        </div>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Status</span>

                                            <span class="m2-1" data-bs-toggle="tooltip"
                                                title="Complete your company registrastion to open all feature">
                                                <i class="ki-duotone ki-information fs-7"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span></i>
                                            </span>
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Col-->
                                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                            <input type="text" name="status"
                                                class="form-control form-control-lg form-control-solid"
                                                readonly value="{{ $company ? $company->status : 'Not Complete' }}">
                                            <div
                                                class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card body-->

                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="reset"
                                        class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                    {{-- <button type="submit" class="btn btn-primary" id="kt_company_profile_submit">Save
                                        Changes</button> --}}
                                        <button type="submit" id="kt_company_profile_submit" class="btn btn-primary">
                                            @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
                                        </button>
                                </div>
                                <!--end::Actions-->
                                <input type="hidden">
                            </form>
                            <!--end::Form-->
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                            Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim
                            reprehenderit.
                            Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non
                            exercitation velit laboris fugiat cupidatat.
                            Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip
                            ipsum aute laboris nisi.
                            Labore labore veniam irure irure ipsum pariatur mollit magna in cupidatat dolore magna irure
                            esse tempor ad mollit.
                            Dolore commodo nulla minim amet ipsum officia consectetur amet ullamco voluptate nisi
                            commodo ea sit eu.
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_9" role="tabpanel">
                            Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat
                            sunt do.
                            Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim
                            cupidatat.
                            eserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui
                            reprehenderit nostrud tempor.
                            Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim.
                            Consequat aliquip incididunt
                            ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id
                            nulla minim nostrud labore eiusmod et amet.
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_10" role="tabpanel">
                            Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim
                            occaecat veniam.
                            Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim.
                            Velit non irure adipisicing aliqua
                            ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet
                            duis do nisi duis veniam non est eiusmod
                            tempor incididunt tempor dolor ipsum in qui sit.
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_11" role="tabpanel">
                            Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim
                            reprehenderit.
                            Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non
                            exercitation velit laboris fugiat cupidatat.
                            Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip
                            ipsum aute laboris nisi.
                            Labore labore veniam irure irure ipsum pariatur mollit magna in cupidatat dolore magna irure
                            esse tempor ad mollit.
                            Dolore commodo nulla minim amet ipsum officia consectetur amet ullamco voluptate nisi
                            commodo ea sit eu.
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_12" role="tabpanel">
                            Sint sit mollit irure quis est nostrud cillum consequat Lorem esse do quis dolor esse fugiat
                            sunt do.
                            Eu ex commodo veniam Lorem aliquip laborum occaecat qui Lorem esse mollit dolore anim
                            cupidatat.
                            eserunt officia id Lorem nostrud aute id commodo elit eiusmod enim irure amet eiusmod qui
                            reprehenderit nostrud tempor.
                            Fugiat ipsum excepteur in aliqua non et quis aliquip ad irure in labore cillum elit enim.
                            Consequat aliquip incididunt
                            ipsum et minim laborum laborum laborum et cillum labore. Deserunt adipisicing cillum id
                            nulla minim nostrud labore eiusmod et amet.
                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_13" role="tabpanel">
                            Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim
                            occaecat veniam.
                            Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim.
                            Velit non irure adipisicing aliqua
                            ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet
                            duis do nisi duis veniam non est eiusmod
                            tempor incididunt tempor dolor ipsum in qui sit.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    @push('scripts')
    {{-- <script src="/assets/js/custom/settings/setting-methods.js"></script> --}}
    @endpush

</x-default-layout>
