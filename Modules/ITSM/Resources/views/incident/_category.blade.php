<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card-header collapsible cursor-pointer rotate">
        <h3 class="card-title">Incident Category</h3>

        @if($canCreateIncidentCategory)
        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-primary" id="kt_new_incident_category">
                <i class="ki-duotone ki-plus fs-2"></i> Make Incident Category
            </button>
            <!--end::Menu-->
        </div>
        @endif
    </div>
    <div id="kt_docs_card_ticket_list" class="collapse show">
        <div class="card-body">
            <table id="incidentCategory-tables" class="display nowrap table table-striped table-row-bordered gy-5 gs-7"
                style="width:100%">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th class="w-25px">#</th>
                        <th class="min-w-100px">ID</th>
                        <th class="min-w-140px">Title</th>
                        <th class="min-w-120px">Description</th>
                        <th class="min-w-100px">Created At</th>
                        <th class="min-w-100px">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('itsm::incident._formCategory')
@push('scripts')
<script>
    // Get the last day of the current month
        function getIncidentCategory() {

            // Destroy datatables before init
            $("#incidentCategory-tables").DataTable().destroy();

            var dtStatus, dtButtons;

            dtButtons = ['reload', 'print', 'colvis'];

            $.fn.dataTable.ext.buttons.reload = {
                text: 'Reload',
                action: function(e, dt, node, config) {
                    $('#incidentCategory-tables').DataTable().ajax.reload();
                }
            };

            dtCategory = $("#incidentCategory-tables").DataTable({
                ajax: {
                    url: "/apps/itsm/api/incidentCategories",
                    data: {
                        task: 'GET_INCIDENT_CATEGORY',
                    },
                },
                columns: [{
                        targets: 0,
                        data: null,
                        render: function(data, type, row, meta) {
                            // 'meta.row' contains the row number
                            return meta.row + 1;
                        },
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'description',
                    },
                    {
                        data: 'created_at',
                        title: 'Created Date',
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                // Format the date using moment.js
                                return moment(data).format('YYYY-MM-DD HH:mm:ss');
                            }
                            return data; // For sorting and other types
                        }
                    },
                    {
                        data: 'action',
                    },

                ],
                columnDefs: [{
                    targets: [1, 4], // index of the column you want to disable ColVis for (0-based index)
                    visible: false,
                    searchable: false, // optional: hide from search
                }, ],
                dom: 'Bfrtip',
                buttons: dtButtons,

                // Use the passed data
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            dtCategory.on('draw', function() {
                KTMenu.init(); // reinit KTMenu instances
            });

            
        }

        $('#incidentCategory-tables').on('click', '.edit-category', function(e) {
            e.preventDefault();

            // Change the title text when the button is clicked
            categoryTitleForm.innerText = 'Edit Category';

            // Select parent row
            const parent = e.target.closest('tr');

            // Get subject name
            const incidentTitle = parent.querySelectorAll('td')[1].innerText;
            const incidentId = $(this).data('id');

            // Simulate delete request -- for demo purpose only
            Swal.fire({
                html: `Load Data <b>`+ incidentTitle +`</b>`,
                icon: "info",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 2000
            }).then(function () {
                // Open the modal
                $('#kt_modal_category').modal('show');

                $.ajax({
                    url: "/apps/itsm/api/incidentCategories",
                    type: 'GET',
                    data: {
                        id: incidentId,
                        task: 'GET_INCIDENT_CATEGORY',
                    },
                    success: function(response) {
                        $('#title').val(response.name);
                        $('#description_category').val(response.description);


                        // Find the input element by its id
                        var categoryInput = document.getElementById('title');
                        categoryInput.setAttribute('readonly', true);

                        // // Create a new hidden input element
                        var hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.id = "category_id";
                        hiddenInput.name = "category_id";
                        hiddenInput.className = "form-control form-control-solid";
                        hiddenInput.value = response.id;
                        hiddenInput.readOnly = true;

                        // // Find the form by its id and append the hidden input to it
                        document.getElementById("kt_modal_new_category_form").appendChild(hiddenInput);
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

                        console.error('Error:', error);
                    }
                });
            });
        });



        $(document).ready(function() {

        });
</script>
@endpush