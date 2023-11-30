<x-default-layout>
<button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#adsScheduleModal">
        {!! getIcon('plus-square','fs-3') !!}
        test modal
        </button>


<!-- Modal form to rekap nilaiSiswa -->
<!-- <div id="adsScheduleModal" class="modal fade" role="dialog" data-backdrop="static"  data-keyboard="false" tabindex="-1" aria-labelledby="adsScheduleModalLabel" aria-hidden="true"> -->
<div class="modal fade" id="adsScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Rekap Nilai</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
                <div class="modal-body">
                <table id="schedule-table" class="display">
    <thead>
        <tr>
            <th>Id</th>
            <th>User Id</th>
            <th>Client Id</th>
            <th>Ads Id</th>
            <th>Site Id</th>
            <th>Ads Time</th>
            <th>Days</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
</table>           
				</div>
            </div>
        </div>
    </div>
<!-- Attachment Modal -->


@push('scripts')
    <script>


        $(document).ready(function() {

            $('#adsScheduleModal').on('shown.bs.modal', function (e) {
    $('#schedule-table').DataTable().ajax.reload();
});
    
});

$('#schedule-table').DataTable({
        destroy: true,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: "/apps/adsportal/getads",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_id', name: 'user_id' },
            { data: 'client_id', name: 'client_id' },
            { data: 'ads_id', name: 'ads_id' },
            { data: 'site_id', name: 'site_id' },
            { data: 'ads_time', name: 'ads_time' },
            { data: 'days', name: 'days' },
            { data: 'duration', name: 'duration' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ]
    });
         </script>
    @endpush

    </x-default-layout>