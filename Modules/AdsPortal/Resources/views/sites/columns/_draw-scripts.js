// Initialize KTMenu
KTMenu.init();


// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (confirm('Are you sure you want to remove?')) {
            Livewire.emit('delete_site', this.getAttribute('data-adssite-id'));
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('modal.show.site_id', this.getAttribute('data-adssite-id'));
        console.log(this.getAttribute('data-adssite-id'));

    });
});