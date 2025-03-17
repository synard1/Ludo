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

$('#addBtn').on('click', function () {

    $('#addDepartmentModal').modal('show'); // Show the Add Category Modal
});


// Handle Asset Type Submission
$('#addDepartmentForm').on('submit', function (e) {
    e.preventDefault();

    let typeName = $('#department-name').val().trim();
    var submitButton = $('#addDepartmentForm button[type="submit"]'); // Get submit button

    // **Disable submit button to prevent multiple clicks**
    submitButton.prop('disabled', true).text('Updating...');

    $.ajax({
        url: "/api/v1/itam/department",
        type: "POST",
        data: { name: typeName },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");
            $('#addDepartmentModal').modal('hide');
            $('#addDepartmentForm')[0].reset();
            $('#department-table').DataTable().ajax.reload(); // Reload DataTable

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
        },
        complete: function () {
            // **Re-enable button after request completes**
            submitButton.prop('disabled', false).text('Add Department');
        }
    });
});

// Add click event listener to delete buttons
$('#department-table').on('click', '.delete-row', function(e) {
    e.preventDefault();

    var button = $(this);
    var parentRow = button.closest('tr');
    var dataTitle = parentRow.find('td:eq(1)').text(); // Get category name
    var dataId = button.data('id'); // Ensure the button has 'data-id' attribute

    Swal.fire({
        text: `Are you sure you want to delete department: ${dataTitle}?`,
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
                url: `/api/v1/itam/department/${dataId}`,
                type: "DELETE",
                success: function(response) {
                    Swal.fire({
                        text: `Department "${dataTitle}" has been deleted!`,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    }).then(() => {
                        $('#department-table').DataTable().row(parentRow).remove().draw(); // Remove row from DataTable
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.error || "Failed to delete department.";

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

$('#department-table').on('click', '.edit-transaction', function () {
    var dataId = $(this).data('id').trim();

    $.ajax({
        url: `/api/v1/itam/department/${dataId}/edit`,
        type: "GET",
        success: function (response) {
            // Populate modal with category data
            $('#edit-department-id').val(response.id);
            $('#edit-department-name').val(response.name);

            // Show modal
            $('#editDepartmentModal').modal('show');
        },
        error: function () {
            Swal.fire("Error!", "Failed to fetch department details.", "error");
        }
    });
});

$('#editDepartmentForm').submit(function (e) {
    e.preventDefault();

    var departmentId = $('#edit-department-id').val();
    var departmentName = $('#edit-department-name').val();

    $.ajax({
        url: `/api/v1/itam/department/${departmentId}`,
        type: "PUT",
        data: {
            name: departmentName,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
        },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");

            $('#editDepartmentModal').modal('hide'); // Close modal

            $('#department-table').DataTable().ajax.reload(); // Reload DataTable
        },
        error: function (xhr) {
            let errorMessage = xhr.responseJSON?.error || "Failed to update department.";
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
