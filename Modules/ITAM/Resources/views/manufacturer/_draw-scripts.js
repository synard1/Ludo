// Initialize KTMenu
KTMenu.init();

const showLoadingSpinner = () => {
    const loadingEl = document.createElement("div");
    document.body.append(loadingEl);
    loadingEl.classList.add("page-loader");
    loadingEl.innerHTML = `
        <span class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </span>
    `;
    KTApp.showPageLoading();
    setTimeout(() => {
        KTApp.hidePageLoading();
        loadingEl.remove();
    }, 3000);
};

$('#addCategoryBtn').on('click', function () {

    $('#addManufacturerModal').modal('show'); // Show the Add Category Modal
});


// Handle Asset Type Submission
$('#addManufacturerForm').on('submit', function (e) {
    e.preventDefault();

    let typeName = $('#manufacturer-name').val().trim();

    $.ajax({
        url: "/api/v1/itam/manufacturer",
        type: "POST",
        data: { name: typeName },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");
            $('#addManufacturerModal').modal('hide');
            $('#addManufacturerForm')[0].reset();
            $('#manufacturer-table').DataTable().ajax.reload(); // Reload DataTable

        },
        error: function (xhr) {
            let errorMessage = "Something went wrong.";
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                // Extract the first validation error message
                let errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join("<br>"); // Join multiple errors with line breaks
            } else if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error; // Handle other errors
            }
        
            Swal.fire("Error!", errorMessage, "error");
        }
    });
});

// Add click event listener to delete buttons
$('#manufacturer-table').on('click', '.delete-row', function(e) {
    e.preventDefault();

    var button = $(this);
    var parentRow = button.closest('tr');
    var dataTitle = parentRow.find('td:eq(1)').text(); // Get category name
    var dataId = button.data('id'); // Ensure the button has 'data-id' attribute

    Swal.fire({
        text: `Are you sure you want to delete manufacturer: ${dataTitle}?`,
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform AJAX delete request
            $.ajax({
                url: `/api/v1/itam/manufacturer/${dataId}`,
                type: "DELETE",
                success: function(response) {
                    Swal.fire({
                        text: `Manufacturer "${dataTitle}" has been deleted!`,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    }).then(() => {
                        $('#manufacturer-table').DataTable().row(parentRow).remove().draw(); // Remove row from DataTable
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.error || "Failed to delete manufacturer.";

                    Swal.fire({
                        text: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        }
    });
});

$('#manufacturer-table').on('click', '.edit-transaction', function () {
    var dataId = $(this).data('id').trim();

    $.ajax({
        url: `/api/v1/itam/manufacturer/${dataId}/edit`,
        type: "GET",
        success: function (response) {
            // Populate modal with category data
            $('#edit-manufacturer-id').val(response.id);
            $('#edit-manufacturer-name').val(response.name);

            // Show modal
            $('#editManufacturerModal').modal('show');
        },
        error: function () {
            Swal.fire("Error!", "Failed to fetch manufacturer details.", "error");
        }
    });
});

$('#editManufacturerForm').submit(function (e) {
    e.preventDefault();

    var manufacturerId = $('#edit-manufacturer-id').val();
    var manufacturerName = $('#edit-manufacturer-name').val();

    $.ajax({
        url: `/api/v1/itam/manufacturer/${manufacturerId}`,
        type: "PUT",
        data: {
            name: manufacturerName,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
        },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");

            $('#editManufacturerModal').modal('hide'); // Close modal

            $('#manufacturer-table').DataTable().ajax.reload(); // Reload DataTable
        },
        error: function (xhr) {
            let errorMessage = xhr.responseJSON?.error || "Failed to update manufacturer.";
            Swal.fire("Error!", errorMessage, "error");
        }
    });
});


// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('update_service', this.getAttribute('data-kt-service-id'));
    });
});


// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the services-table datatable
    LaravelDataTables['assets-table'].ajax.reload();
});

Livewire.on('showDetailsModal', () => {
    var myModal = new bootstrap.Modal(document.getElementById('assetDetailsModal'));
    myModal.show();
});
