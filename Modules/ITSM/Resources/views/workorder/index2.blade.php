<x-default-layout>
    <div class="card shadow-sm mb-5">
        <div class="card-header collapsible cursor-pointer rotate">
            <h3 class="card-title">Work Order List</h3>
        </div>
        {{-- <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter By Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select id="statusFilter" class="form-control">
                                <option value="">Select Status</option>
                                @foreach($statusWorkOrder as $status => $label)
                                    <option value="{{ $status }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div> --}}
        <div id="kt_docs_card_ticket_list" class="collapse show">
            <div class="card-body">
                <div class="table-responsive">
                <table id="workorders-table"
                    class="display nowrap table table-striped table-row-bordered gy-5 gs-7"
                    style="width:100%">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            {{-- <th class="w-25px">#</th> --}}
                            <th class="min-w-100px">Subject</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-120px">Reporter</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-160px">Description</th>
                            <th class="min-w-100px">Due Date</th>
                            <th class="min-w-100px">Due Date</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-100px">Created At</th>
                            <th class="min-w-100px text-end">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            {{-- <th class="w-25px">#</th> --}}
                            <th class="min-w-100px">Subject</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-120px">Reporter</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-160px">Description</th>
                            <th class="min-w-100px">Due Date</th>
                            <th class="min-w-100px">Due Date</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-140px">Staff Assign</th>
                            <th class="min-w-100px">Created At</th>
                            <th class="min-w-100px text-end">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
        </div>
    </div>

    @include('itsm::workorder/_response')

    @push('styles')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/2.3.1/css/searchPanes.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/2.0.3/css/select.dataTables.css"> --}}


    @endpush

    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {{-- <script src="https://cdn.datatables.net/searchpanes/2.3.1/js/dataTables.searchPanes.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.1/js/searchPanes.dataTables.js"></script> --}}
    {{ $dataTable->scripts() }}

    {{-- <script>
        $('#workorders-table').on('click', '.generate-work-order-response', function() {
                var id = $(this).data('id');
                var rowSubject = $(this).data('subject');
                // var rowReportTime = $(this).data('report-time');
                let reportTime = new Date($(this).data('report-time'));
                console.log(reportTime);

                // Assuming you want to set the data-id value to an input field in the modal form
                $('#data_id').val(id);
                $('#workorder_subject').val(rowSubject);
                $('#workorder_id').val(id);

                const linkedPicker1Element = document.getElementById("start_time");
                const linked1 = new tempusDominus.TempusDominus(linkedPicker1Element);
                const linked2 = new tempusDominus.TempusDominus(document.getElementById("finish_time"), {
                    useCurrent: false,
                });

                linked1.updateOptions({
                        restrictions: {
                            minDate: reportTime,
                        },
                    });

                //using event listeners
                linkedPicker1Element.addEventListener(tempusDominus.Namespace.events.change, (e) => {
                    linked2.updateOptions({
                        restrictions: {
                        minDate: e.detail.date,
                        },
                    });
                });

                //using subscribe method
                const subscription = linked2.subscribe(tempusDominus.Namespace.events.change, (e) => {
                    linked1.updateOptions({
                        restrictions: {
                        maxDate: e.date,
                        },
                    });
                });

                // Rest of your code
                // console.log('Generate work order response for ID: ' + id + ' ' + rowSubject + ' ' + reportTime);
                // getWoResponse(id);

                // $("#start_date").flatpickr({
                //     enableTime: true,
                //     dateFormat: "Y-m-d H:i",
                //     // maxDate: new Date(),
                //     // minDate: reportTime,
                //     minuteIncrement: 1
                // });

                // $("#finish_date").flatpickr({
                //     enableTime: true,
                //     dateFormat: "Y-m-d H:i",
                //     // maxDate: new Date(),
                //     // minDate: reportTime,
                //     minuteIncrement: 1
                // });


            });

            function getWoResponse(id) {
                    // Get Response Data
                    $.ajax({
                        url: "{{ url('/apps/itsm/api/workorder/response') }}/" +
                        id, // Use a route parameter for the ID
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 200) {
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
                            }

                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

            // Assuming you're using jQuery for simplicity
            $('#workorders-table').on('click', '.delete-button', function() {
                    var workOrderId = $(this).data('id');
                    // Show a confirmation dialog if needed
                    if (confirm('Are you sure you want to delete this work order?')) {
                        // Send an AJAX request to delete the record
                        $.ajax({
                            url: '/apps/itsm/api/workorder/' + workOrderId,
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
    </script> --}}

    <script>
        $(document).ready(function() {
            var table = $('#workorders-table').DataTable();

            $('#statusFilter').change(function() {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var status = $('#statusFilter').val();
                    var rowStatus = data[9]; // Adjust this index based on your table

                    if (status == '' || rowStatus == status) {
                        return true;
                    }
                    return false;
                }
            );
        });

        $('#workorders-table').on('click', '.open-wo', function(e) {
            e.preventDefault();
            const parent = e.target.closest('tr');

            // Get subject name
            const workorderNumber = parent.querySelectorAll('td')[1].innerText;
            // const workorderId = $(this).data('number');
            var outputType = "PRINT";
            // var number = workorderNumber;

            $.ajax({
                    // url: '/apps/itsm/api/workorder',
                    // url: '/apps/itsm/api/workorder/' + workorderId,
                    url: '/apps/itsm/api/workorder',
                    type: 'POST',
                    data: {
                        number: workorderNumber,
                        task: 'WORK_ORDER_PRINT',
                        outputType: outputType,
                    },
                    success: function(result) {
                        console.log(workorderNumber);
                        if(result == '1'){
                            window.open('./print/wo/WorkOrder_'+workorderNumber+'.html?random='+new Date().getTime(),'workorder','height=600,width=800,resizable=1,scrollbars=1, menubar=0');
                        }else{
                            console.log('Error');
                        }
                    }
                });
        });
    </script>
    @endpush

</x-default-layout>
