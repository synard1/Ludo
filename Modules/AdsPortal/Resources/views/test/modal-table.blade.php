<div class="modal fade" id="adsScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ads Schedule</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="schedule-table" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Id</th>
                            <th>Client Id</th>
                            <th>Ads Id</th>
                            <th>Site Id</th>
                            <th>Ads Time</th>
                            <th>Days</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Attachment Modal -->


@push('scripts')

@endpush