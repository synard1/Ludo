<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Work Order List</h3>
            @if ($canCreateWorkorder)
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button type="button" class="btn btn-primary" id="kt_new_ticket">
                        <i class="ki-duotone ki-plus fs-2"></i> New Work Order
                    </button>
                    <!--end::Menu-->
                </div>
            @endif
        </div>
        <div id="kt_docs_card_workorder_list" class="collapse show">
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                {{ $dataTable->table() }}
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>

    @include('helpdesk::workorder/work_order_response')

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script src="/vendor/datatables/buttons.server-side.js"></script>
        {{ $dataTable->scripts() }}

        <script>
            // Pass data to JavaScript
            var canCreateWorkorder = @json($canCreateWorkorder);
            var isSupervisor = @json($isSupervisor);

            $('#workOrders-table').on('click', '.generate-work-order-response', function() {
                var id = $(this).data('id');
                var rowSubject = $(this).data('subject');
                // var rowReportTime = $(this).data('report-time');
                var reportTime = new Date($(this).data('report-time'));
                var rowId = $(this).data('id');

                // Assuming you want to set the data-id value to an input field in the modal form
                $('#ticket_id').val(rowId);
                $('#workorder_subject').val(rowSubject);
                $('#workorder_id').val(rowId);

                // Rest of your code
                console.log('Generate work order response for ID: ' + id + ' ' + rowSubject + ' ' + reportTime);
                getWoResponse(id);

                $("#start_date").flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: reportTime,
                    minuteIncrement: 1
                });

                $("#finish_date").flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: reportTime,
                    minuteIncrement: 1
                });

                function getWoResponse(id) {
                    // Get Response Data
                    $.ajax({
                        url: "{{ url('/apps/helpdesk/api/woresponse') }}/" +
                        id, // Use a route parameter for the ID
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            // Handle the response, for example, append data to a container
                            console.log(response);
                            $('#start_date').val(response.start_time);
                            $('#finish_date').val(response.end_time);
                            // $('#description_response').val(response.response);
                            $('#status').val(response.status);

                            // Assuming response.response contains the content you want to set
                            var responseContent = response.response;

                            // Set the content of the TinyMCE editor
                            tinymce.activeEditor.setContent(responseContent);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                // Assuming you're using jQuery for simplicity
                $('#workOrders-table').on('click', '.delete-button', function() {
                    var workOrderId = $(this).data('id');
                    // Show a confirmation dialog if needed
                    if (confirm('Are you sure you want to delete this work order?')) {
                        // Send an AJAX request to delete the record
                        $.ajax({
                            url: '/apps/helpdesk/api/deleteWorkOrder/' + workOrderId,
                            type: 'DELETE',
                            success: function(response) {
                                // Refresh the DataTable or remove the row from the table
                                // depending on your implementation
                                swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                }).then(function() {
                                    tableWorkOrder.ajax.reload();
                                });
                            },
                            error: function(error) {
                                console.error('Error deleting work order:', error);
                            }
                        });
                    }
                });

            });
        </script>
    @endpush

</x-default-layout>
