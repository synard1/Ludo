<div class="modal fade" id="kt_modal_ads_schedule" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add New Schedule</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                @if (session('warning'))
                    <div class="alert alert-error">
                        {{ session('warning') }}
                    </div>
                @endif
                <!--begin::Form-->
                <form id="kt_modal_ads_schedule_form" class="form" action="#" wire:submit.prevent="submit">
                    <!--begin::Input group-->
                    {{-- <input type="hidden" wire:model="status" value="2"/> --}}
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Time</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid" placeholder="Pick time" id="kt_datepicker_8" wire:model="ads_time"/>

                        <!--end::Input-->
                        @error('duration')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Day</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                    <select wire:model="days" class="form-control form-control-solid">
                        <option value="">-- Choose Day --</option>
                        @foreach (config('onexolution.days') as $key => $d)
							<option value="{{$key}}">{{$d}}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                        @error('days')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            <span class="required">Ads Site</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select wire:model="site_id" class="form-control form-control-solid">
                        <option value="">-- Choose Site --</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->sites }}</option>
                            @endforeach
                        </select>
                    <!--end::Input-->
                        @error('days')
                        <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <!--end::Input group-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-add-sched-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-add-sched-action="submit">
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

@push('styles')
<!-- Tempus Dominus Styles -->

@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>

<script>
$("#kt_datepicker_8").flatpickr({
    enableTime: true,
    noCalendar: true,
    // dateFormat: "H:i",
    timeFormat: 'HH:mm',
});
 </script>
    <!-- <script>

        const modal = document.querySelector('#kt_modal_ads_schedule');
        </script> -->
@endpush
