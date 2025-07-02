// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
// document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
//     element.addEventListener('click', function () { 
// });
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'Are you sure you want to remove?',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete_changes', [this.getAttribute('data-kt-change-id')]);
            }
        });
    });
});

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

// // Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_data"]').forEach(function (element) {
    element.addEventListener('click', function () {

        const form = document.getElementById("kt_new_change_form");
        const cardChangeNew = document.getElementById("kt_docs_card_change_new");
        const cardChangeList = document.getElementById("kt_docs_card_change_list");

        showLoadingSpinner();

        $(cardChangeNew).collapse("show");
        $(cardChangeList).collapse("hide");
        cardChangeNew.parentNode.classList.remove("d-none");
        cardChangeList.parentNode.classList.add("d-none");

        const changeId = event.currentTarget.getAttribute('data-kt-change-id');

        console.log('button edit click : ' + changeId);
        Livewire.dispatch('update_changes', [changeId]);
        // console.log('set tinymce');

        
    });
});

window.addEventListener('tinymce-update', event => {
    console.log(event.detail);
    tinymce.get('description').setContent(event.detail.descriptionFormat);
    tinymce.get('impact_assessment').setContent(event.detail.impact_assessment);
    tinymce.get('rollback_plan').setContent(event.detail.rollback_plan);
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    // Reload the services-table datatable
    LaravelDataTables['changes-table'].ajax.reload();
});


