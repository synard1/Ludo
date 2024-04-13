@php
    // Declaration
    $modules = config('notification.modules');
    $platform = config('notification.platform');
    $bot_telegram = config('onexolution.system.notification.telegram');
    $telegram_instruction = config('onexolution.system.notification.telegram_instruction');
    

@endphp

<div class="tab-pane fade" id="kt_tab_notification" role="tabpanel">
    <div class="card card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Telegram Bot</h3>
            </div>
        </div>
        <!--begin::Card header-->
        <!--begin::Form-->
        <form id="kt_telegram_config_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            novalidate="novalidate" enctype="multipart/form-data">
            <input type="hidden" name="type" id="type" value="Telegram">
            <!--begin::Card body-->
            <div class="card-body p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span>Telegram Bot Token</span>

                        <span class="m2-1" data-bs-toggle="tooltip" title="">
                            <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span></i>
                        </span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col for mttr-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @if( auth()->user()->subscription == 'Free')
                        <input type="text" class="form-control form-control-lg form-control-solid" placeholder="{{$bot_telegram}}" readonly>
                        <span class="text-gray-500 fw-semibold d-block fs-7">{!!$telegram_instruction!!}</span>

                        @else
                        <input type="text" min="0" name="bot_token" id="bot_token"
                            class="form-control form-control-lg form-control-solid" value="{{ $tokenTele }}">
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                        @endif
                        
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span>Telegram Group/User Recipient</span>

                        <span class="m2-1" data-bs-toggle="tooltip" title="">
                            <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span></i>
                        </span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col for art-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input type="text" min="0" name="recipient" id="recipient"
                            class="form-control form-control-lg form-control-solid" value="{{ $teleRecipient }}">
                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="d-flex flex-stack w-lg-50">
                    <!--begin::Label-->
                    <div class="me-5">
                        <label class="fs-6 fw-semibold form-label">Use Telegram Bot To Send Notification?</label>
                        {{-- <div class="fs-7 fw-semibold text-muted">If you need more info, please check budget
                            planning</div> --}}
                    </div>
                    <!--end::Label-->

                    <!--begin::Switch-->
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" name="active" id="active" type="checkbox" value="1"
                            checked="checked" onclick="toggleTelegramInputs()" />
                        <span class="form-check-label fw-semibold text-muted">
                            Active
                        </span>
                    </label>
                    <!--end::Switch-->
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button type="button" class="btn btn-primary me-10" id="kt_notification_telegram_test">
                    <span class="indicator-label">
                        Test Telegram
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <button type="submit" id="kt_config_telegram_submit" class="btn btn-primary">
                    @include('partials/general/_button-indicator', ['label' => 'Save Changes'])
                </button>
                
            </div>
            <!--end::Actions-->
            <input type="hidden">
        </form>
        <!--end::Form-->
    </div>
    <div class="card  mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Notifications</h3>
            </div>
        </div>
        <!--begin::Card header-->

        <!--begin::Content-->
        <div id="kt_account_settings_notifications" class="collapse show">
            <!--begin::Form-->
            <form id="kt_notification_telegram_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" enctype="multipart/form-data">
                <!--begin::Card body-->
                <div class="card-body border-top px-9 pt-3 pb-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                            <tbody class="fs-6 fw-semibold">
                                <!-- Check-all row for platforms -->
                                <tr>
                                    <td class="min-w-250px fs-4 fw-bold"></td>
                                    <!-- Iterate over each platform -->
                                    @foreach ($platform as $key => $value)
                                        <td class="w-125px">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <!-- Check-all checkbox -->
                                                @if (!$value['disabled'])
                                                <input class="form-check-input check-all" type="checkbox" data-platform="{{ $key }}">
                                                @else
                                                    <input class="form-check-input check-all" type="checkbox" data-platform="{{ $key }}" disabled>
                                                @endif
                                                <label class="form-check-label ps-2"
                                                    for="kt_settings_notification_{{ $key }}">
                                                    {{ ucfirst($value['label']) }}
                                                </label>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                                <!-- Iterate over the modules -->
                                @foreach ($modules as $module => $subModules)
                                    <!-- Row group for module name -->
                                    <tr>
                                        <!-- Module name -->
                                        <th class="min-w-250px fs-4 fw-bold" colspan="{{ count($platform) + 1 }}">
                                            {{ $module }}</th>
                                    </tr>

                                    <!-- Iterate over each sub-module -->
                                    @foreach ($subModules as $subModule)
                                        <tr>
                                            <!-- Render sub-module name -->
                                            <td class="min-w-250px">{{ $subModule }}</td>
                                            <!-- Iterate over each platform -->
                                            @foreach ($platform as $key => $value)
                                                <td>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <!-- Regular checkbox -->
                                                        @if (!$value['disabled'])
                                                            <input class="form-check-input" type="checkbox"
                                                                name="notif[]"
                                                                value="{{ $key }}_{{ $module }}_{{ $subModule }}"
                                                                id="{{ $key }}_{{ $module }}_{{ $subModule }}"
                                                                data-kt-settings-notification="{{ $value['label'] }}">
                                                        @else
                                                            <input class="form-check-input" type="checkbox"
                                                                name="notif[]"
                                                                value="{{ $key }}_{{ $module }}_{{ $subModule }}"
                                                                id="{{ $key }}_{{ $module }}_{{ $subModule }}"
                                                                data-kt-settings-notification="{{ $value['label'] }}"
                                                                disabled>
                                                        @endif
                                                        <label class="form-check-label ps-2"
                                                                for="{{ $subModule }}{{ $key }}">{{ ucfirst($value['label']) }}</label>
                                                        <!-- Render the label only if the platform is not disabled -->
                                                        {{-- @unless ($value['disabled'])
                                                            <label class="form-check-label ps-2"
                                                                for="{{ $subModule }}{{ $key }}">{{ ucfirst($value['label']) }}</label>
                                                        @endunless --}}
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->

                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-light btn-active-light-primary me-2"
                        onclick="discardChanges()">Discard</button>
                    <button type="button" class="btn btn-primary px-6" onclick="saveChanges()">Save Changes</button>
                </div>
                <!--end::Card footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Attach a click event handler to the tab links
            $('.nav-link').on('shown.bs.tab', function(e) {
                // Log the tab that has been shown
                // console.log('Tab shown:', e.target.href);

                // Check if the clicked tab has the id kt_incident_general
                if (e.target.href.includes('#kt_tab_notification')) {
                    // Show an alert when kt_incident_general tab is clicked

                    // getNotification();
                }
            });
        });

        // Get the last day of the current month
        function getNotification() {
            // alert('kt_incident_general tab clicked');
            $.ajax({
                    url: '{{ route('settings.getNotification') }}',
                    type: 'GET',
                    // data: {
                    //     id: incidentId,
                    // },
                    success: function(response) {
                        console.log(response.notif);

                        response.notif.forEach(function(notification) {
                            $('input[name="notif[]"][value="' + notification + '"]').prop('checked', true);
                        });

                    },
                    error: function (error) {
                        let errorMessage = "Sorry, looks like there are some errors detected, please try again.";

                        if (error.responseJSON && error.responseJSON.message) {
                            errorMessage = error.responseJSON.message;
                        }

                        Swal.fire({
                            text: errorMessage,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });

                        console.error('Error deleting incident:', error);
                    }
                });

        }

        function saveChanges() {
            var formData = new FormData($('#kt_notification_form')[0]);
            $.ajax({
                url: '{{ route('settings.postNotification') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    console.log(formData);
                    console.error(xhr.responseText);
                    // Handle error response
                }
            });
        }

        function discardChanges() {
            // Implement discard changes functionality here
            console.log('Changes discarded');
        }
    </script>
    <script>
        // Add event listener to the document for event delegation
        document.addEventListener('change', function(event) {
            // Check if the changed element is a check-all checkbox
            if (event.target.classList.contains('check-all')) {
                toggleInputs(event.target);
            }
        });

        // Function to toggle all inputs for a specific platform within the same module
        function toggleInputs(checkAll) {
            let platform = checkAll.dataset.platform;
            let checkboxes = document.querySelectorAll('[data-kt-settings-notification="' + platform + '"]');

            checkboxes.forEach(function(checkbox) {
                if (checkbox) { // Check if the checkbox exists
                    checkbox.checked = checkAll.checked;
                }
            });
        }
    </script>
    <script>
        function toggleTelegramInputs() {
            var activeTelegram = document.getElementById('activeTelegram').checked;
            var botTokenInput = document.getElementById('bot_token');
            var botRecipientInput = document.getElementById('bot_recipient');

            botTokenInput.disabled = !activeTelegram;
            botRecipientInput.disabled = !activeTelegram;
        }

        // Call the function initially to set the initial state
        // toggleTelegramInputs();
    </script>
@endpush
