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

// const loadSpec = () => {
//     const assetData = @json($assets);
//     const assetTypeSelect = document.getElementById("assetType");
//     const dynamicFields = document.getElementById("dynamicFields");

//     if (!assetTypeSelect || !dynamicFields) {
//         console.error("Element not found: #assetType or #dynamicFields");
//         return;
//     }

//     const clearDynamicFields = () => {
//         dynamicFields.innerHTML = "";
//     };

//     const createDynamicFieldSection = (label, maxCount, fieldId, addButtonId, inputName) => {
//         const sectionDiv = document.createElement("div");
//         sectionDiv.innerHTML = `
//             <label>${label} (Max: ${maxCount})</label>
//             <div id="${fieldId}"></div>
//             <button type="button" id="${addButtonId}" class="btn btn-sm btn-secondary mt-2">Add ${label.replace(' Slots', '').replace(' Sockets', '')}</button>
//         `;
//         dynamicFields.appendChild(sectionDiv);

//         const fieldsContainer = document.getElementById(fieldId);
//         const addButton = document.getElementById(addButtonId);

//         if (addButton) {
//             addButton.addEventListener("click", () => {
//                 if (fieldsContainer.children.length < maxCount) {
//                     const input = document.createElement("input");
//                     input.type = "text";
//                     input.name = `${inputName}[]`;
//                     input.className = "form-control mb-2";
//                     fieldsContainer.appendChild(input);
//                 }
//             });
//         }
//     };

//     assetTypeSelect.addEventListener("change", () => {
//         clearDynamicFields();
//         const type = assetTypeSelect.value;
//         if (!type || !assetData[type]) return;

//         const maxCPUs = assetData[type].max_cpu_sockets || 0;
//         const ramSlots = assetData[type].ram_slots || 0;

//         if (maxCPUs > 0) {
//             createDynamicFieldSection("CPU Sockets", maxCPUs, "cpuFields", "addCPU", "cpus");
//         }

//         if (ramSlots > 0) {
//             createDynamicFieldSection("RAM Slots", ramSlots, "ramFields", "addRAM", "rams");
//         }
//     });
// };

$('#addCategoryBtn').on('click', function () {
    loadCategories();

    $('#addAssetTypeModal').modal('show'); // Show the Add Category Modal
});

// Load categories into select dropdown
function loadCategories() {
    $.ajax({
        url: "/api/v1/itam/category",
        type: "GET",
        data: {
            // task: 'GET_ITAM_CATEGORY',
            response_type: 'json',
        },
        success: function (data) {
            let categorySelect = $('#asset-category-select');
            categorySelect.empty();
            categorySelect.append('<option value="" selected disabled>Select a category</option>');
            data.forEach(category => {
                categorySelect.append(`<option value="${category.id}">${category.name}</option>`);
            });
        }
    });
}


// Handle Asset Type Submission
$('#addAssetTypeForm').on('submit', function (e) {
    e.preventDefault();

    let categoryId = $('#asset-category-select').val();
    let typeName = $('#add-asset-type-name').val().trim();

    if (!categoryId) {
        Swal.fire("Warning!", "Please select a category first.", "warning");
        return;
    }

    $.ajax({
        url: "/api/v1/itam/type",
        type: "POST",
        data: { category_id: categoryId, name: typeName },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");
            $('#addAssetTypeModal').modal('hide');
            $('#addAssetTypeForm')[0].reset();
            $('#type-table').DataTable().ajax.reload(); // Reload DataTable

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
$('#type-table').on('click', '.delete-row', function(e) {
    e.preventDefault();

    var button = $(this);
    var parentRow = button.closest('tr');
    var dataTitle = parentRow.find('td:eq(2)').text(); // Get category name
    var categoryId = button.data('id'); // Ensure the button has 'data-id' attribute

    Swal.fire({
        text: `Are you sure you want to delete type: ${dataTitle}?`,
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
                url: `/api/v1/itam/type/${categoryId}`,
                type: "DELETE",
                success: function(response) {
                    Swal.fire({
                        text: `Type "${dataTitle}" has been deleted!`,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary"
                        }
                    }).then(() => {
                        $('#type-table').DataTable().row(parentRow).remove().draw(); // Remove row from DataTable
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.error || "Failed to delete type.";

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

$('#type-table').on('click', '.edit-transaction', function () {
    var categoryId = $(this).data('id').trim();

    $.ajax({
        url: `/api/v1/itam/type/${categoryId}/edit`,
        type: "GET",
        success: function (response) {
            // Populate modal with category data
            $('#edit-category-id').val(response.id);
            $('#edit-category-name').val(response.name);

            // Show modal
            $('#editCategoryModal').modal('show');
        },
        error: function () {
            Swal.fire("Error!", "Failed to fetch category details.", "error");
        }
    });
});

$('#editCategoryForm').submit(function (e) {
    e.preventDefault();

    var categoryId = $('#edit-category-id').val();
    var categoryName = $('#edit-category-name').val();

    $.ajax({
        url: `/api/v1/itam/type/${categoryId}`,
        type: "PUT",
        data: {
            name: categoryName,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
        },
        success: function (response) {
            Swal.fire("Success!", response.message, "success");

            $('#editCategoryModal').modal('hide'); // Close modal

            $('#type-table').DataTable().ajax.reload(); // Reload DataTable
        },
        error: function (xhr) {
            let errorMessage = xhr.responseJSON?.error || "Failed to update asset type.";
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
