// Initialize KTMenu
KTMenu.init();


// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Livewire.emit('modal.show.user_id', this.getAttribute('data-user-id'));

    });
});