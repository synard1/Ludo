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

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (confirm('Are you sure you want to remove?')) {
            Livewire.emit('delete_user', this.getAttribute('data-kt-service-id'));
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('update_service', this.getAttribute('data-kt-service-id'));
    });
});

// Add click event listener to delete buttons
// document.querySelectorAll('[data-kt-action="add_specification"]').forEach(function (element) {
//     element.addEventListener('click', function (e) {
//         const cardChangeNew = document.getElementById("kt_docs_card_asset_spesification");
//         const cardChangeList = document.getElementById("kt_docs_card_asset_list");
//         const addButtons = document.getElementById('kt_new_asset');
//         const assetId = this.getAttribute('data-id');
//         // const serviceId = $(this).data('id');


//         // Select parent row
//         const parent = e.target.closest('tr');

//         // Get subject name
//         const assetTitle = parent.querySelectorAll('td')[1].innerText;

//         addButtons.style.display = 'none'; // Or button.style.visibility = 'hidden';
//         viewButtons.style.display = ''; // Or button.style.visibility = 'hidden';


//         // addButtons.remove();
//         // viewButtons.add();




//         assetTitle = document.getElementById('assetTitle');


//         // Change the title text when the button is clicked
//         assetTitle.innerText = 'Spesification ' + assetTitle;

//         showLoadingSpinner();

//         $(cardChangeNew).collapse("show");
//         $(cardChangeList).collapse("hide");

//         // Livewire.emit('addSpesification', this.getAttribute('data-id'));
//     });
// });

$('#assets-table').on('click', '.edit-asset', function(e) {
    e.preventDefault();

    // const cardChangeNew = document.getElementById("kt_docs_card_asset_spesification");
    // const cardChangeList = document.getElementById("kt_docs_card_asset_list");
    // const addButtons = document.getElementById('kt_new_asset');
    // const viewButtons = document.getElementById('kt_view_asset'); // Ensure this exists

    // Select parent row
    const parent = e.target.closest('tr');

    // addButtons.style.display = 'none';
    // viewButtons.style.display = '';

    // Get asset name & ID
    const assetsTitle = parent.querySelectorAll('td')[1].innerText;
    const assetsId = $(this).data('id');

    showLoadingSpinner();

    // // Update the title dynamically
    // document.getElementById("assetTitle").innerText = 'Asset Specification - ' + assetsTitle;

    // Close kt_docs_card_incident_new
    $('#kt_docs_card_asset_new').collapse('show');
    // Show kt_docs_card_incident_list
    $('#kt_docs_card_asset_list').collapse('hide');

    // Delay script execution to ensure elements exist
    setTimeout(() => {
        // initializeAssetForm(); // Run form initialization after DOM updates
        const assetId = $(this).data('id');

        Livewire.dispatch('updateAsset', { assetId });
    }, 500);
});

$('#assets-table').on('click', '.add-spesification', function(e) {
    e.preventDefault();

    const cardChangeNew = document.getElementById("kt_docs_card_asset_spesification");
    const cardChangeList = document.getElementById("kt_docs_card_asset_list");
    const addButtons = document.getElementById('kt_new_asset');
    const viewButtons = document.getElementById('kt_view_asset'); // Ensure this exists

    // Select parent row
    const parent = e.target.closest('tr');

    addButtons.style.display = 'none';
    viewButtons.style.display = '';

    // Get asset name & ID
    const assetsTitle = parent.querySelectorAll('td')[1].innerText;
    const assetsId = $(this).data('id');

    showLoadingSpinner();

    // Update the title dynamically
    document.getElementById("assetTitle").innerText = 'Asset Specification - ' + assetsTitle;

    $(cardChangeNew).collapse("show");
    $(cardChangeList).collapse("hide");

    // Delay script execution to ensure elements exist
    setTimeout(() => {
        // initializeAssetForm(); // Run form initialization after DOM updates
        const assetId = $(this).data('id');

        Livewire.dispatch('loadAssetSpecification', { assetId });
    }, 500);
});

// function initializeAssetForm() {
//     const assetData = JSON.parse(`{!! json_encode($assets) !!}`);
//     const assetTypeSelect = document.getElementById("assetType");
//     const dynamicFields = document.getElementById("dynamicFields");

//     if (!assetTypeSelect || !dynamicFields) {
//         console.error("Missing elements: Check if #assetType or #dynamicFields exists in the HTML.");
//         return;
//     }

//     assetTypeSelect.addEventListener("change", function() {
//         dynamicFields.innerHTML = ""; // Clear previous fields

//         let type = assetTypeSelect.value;
//         if (!type || !assetData[type]) return;

//         let maxCPUs = parseInt(assetData[type].max_cpu_sockets || 0);
//         let ramSlots = parseInt(assetData[type].ram_slots || 0);

//         // CPU Fields
//         if (maxCPUs > 0) {
//             let cpuDiv = document.createElement("div");
//             cpuDiv.innerHTML = `
//                 <label>CPU Sockets (Max: ${maxCPUs})</label>
//                 <div id="cpuFields"></div>
//                 <button type="button" id="addCPU" class="btn btn-sm btn-secondary mt-2">Add CPU</button>
//             `;
//             dynamicFields.appendChild(cpuDiv);

//             let cpuFields = document.getElementById("cpuFields");
//             document.getElementById("addCPU").addEventListener("click", function() {
//                 if (cpuFields.children.length < maxCPUs) {
//                     let input = document.createElement("input");
//                     input.type = "number";
//                     input.name = "cpus[]";
//                     input.className = "form-control mb-2";
//                     input.placeholder = "CPU Cores";
//                     cpuFields.appendChild(input);
//                 }
//             });
//         }

//         // RAM Fields
//         if (ramSlots > 0) {
//             let ramDiv = document.createElement("div");
//             ramDiv.innerHTML = `
//                 <label>RAM Slots (Max: ${ramSlots})</label>
//                 <div id="ramFields"></div>
//                 <button type="button" id="addRAM" class="btn btn-sm btn-secondary mt-2">Add RAM</button>
//             `;
//             dynamicFields.appendChild(ramDiv);

//             let ramFields = document.getElementById("ramFields");
//             document.getElementById("addRAM").addEventListener("click", function() {
//                 if (ramFields.children.length < ramSlots) {
//                     let input = document.createElement("input");
//                     input.type = "number";
//                     input.name = "rams[]";
//                     input.className = "form-control mb-2";
//                     input.placeholder = "RAM Size (GB)";
//                     ramFields.appendChild(input);
//                 }
//             });
//         }
//     });
// }

$('#assets-table').on('click', '.details-asset', function(e) {
    e.preventDefault();

    // Select parent row
    const parent = e.target.closest('tr');

    // Get asset name & ID
    const assetsTitle = parent.querySelectorAll('td')[1].innerText;
    const assetsId = $(this).data('id');

    // showLoadingSpinner();

    // Delay script execution to ensure elements exist
    setTimeout(() => {
        // initializeAssetForm(); // Run form initialization after DOM updates
        const assetId = $(this).data('id');

        Livewire.dispatch('viewDetails', { assetId });
    }, 500);
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
