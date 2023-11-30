// Initialize KTMenu
KTMenu.init();


// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (confirm('Are you sure you want to remove?')) {
            Livewire.emit('delete_ads', this.getAttribute('data-ads-id'));
        }
    });
});

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row_image"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (confirm('Are you sure you want to remove?')) {
            Livewire.emit('delete_adsImage', this.getAttribute('data-ads-id'));
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('modal.show.ads_id', this.getAttribute('data-ads-id'));

    });
});

// Add click event listener to add ads schedule buttons
document.querySelectorAll('[data-kt-action="add_schedule"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('modal.show.ads_id', this.getAttribute('data-ads-id'));

    });
});