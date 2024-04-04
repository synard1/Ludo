@php

if(request()->routeIs('adsportal.adsportal.ads-image')){
$adsType = 'image';
}else{
$adsType = 'video';
}

@endphp
<div class="modal fade" id="kt_modal_add_ads" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add New Ads</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_ads_form" class="form" action="#" wire:submit.prevent="submit">
                    <input type="hidden" name="adsType" id="adsType" wire:model.defer="type" />
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Ads Title</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Enter new client name" name="name" wire:model.defer="name" />
                        <!--end::Input-->
                        @error('name')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Url</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Enter new client url" name="url" wire:model.defer="url" />
                        <!--end::Input-->
                        @error('url')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7 form-check form-check-custom form-check-solid">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Video Source</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <br>
                        @foreach($sources as $key => $value)
                            <input class="form-check-input" type="radio" wire:model="source" value="{{ $key }}"> {{ $value }}
                        @endforeach
                        <!--end::Input-->
                        @error('source')
                        <br>
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7" id="durationInput">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Duration</span>
                            <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Ads duration 1 - 300 second.">
                                {!! getIcon('information','fs-7') !!}
                            </span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" name="duration" placeholder="Enter ads duration" wire:model.defer="duration" />
                        <!--end::Input-->
                        @error('duration')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Client</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select wire:model="client_id" class="form-control form-control-solid">
                            <option value="">-- Choose Client --</option>
                            @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                        @error('client_id')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-add-ads-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" wire:submit.prevent="submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<div class="modal fade" id="kt_modal_show_ads_schedule" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Ads Schedule</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <!-- Instead of a table tag -->
            <div class="table">
                <!-- Instead of a thead tag -->
                <div class="thead">
                    <!-- Instead of a tr tag -->
                    <div class="tr">
                        <!-- Instead of th tags -->
                        <div class="th">User Id</div>
                        <div class="th">Client Id</div>
                        <div class="th">Name</div>
                        <div class="th">Url</div>
                        <div class="th">Duration</div>
                        <div class="th">Schedule</div>
                        <div class="th">Action</div>
                    </div>
                </div>
                <!-- Instead of a tbody tag -->
                <div class="tbody">
                    <!-- Instead of a tr tag -->
                    <div class="tr">
                        <!-- Instead of td tags -->
                        <div class="td">Mhd Iqbal Syahputra</div>
                        <div class="td">ISN fsdfsdf</div>
                        <div class="td">test iklan1</div>
                        <div class="td">asdasd</div>
                        <div class="td">60</div>
                        <div class="td">...</div>
                        <div class="td">...</div>
                    </div>
                    <!-- Add more rows as needed -->
                </div>
            </div>

            {{-- <livewire:datatable model="Modules\AdsPortal\Entities\AdsSite" name="all-users" /> --}}
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                @include('adsportal::ads.showads-table')
                <!-- modal content -->
                <table id="adsschedule-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Client ID</th>
                            <th>Site ID</th>
                            <th>Ads ID</th>
                            <th>Days</th>
                            <th>Ads Time</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@push('styles')

@endpush
@push('scripts')


@endpush