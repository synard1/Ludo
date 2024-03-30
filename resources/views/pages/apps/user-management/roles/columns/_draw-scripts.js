// Initialize KTMenu
KTMenu.init();

// Add click event listener to delete buttons
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (confirm('Are you sure you want to remove?')) {
            Livewire.emit('delete_user', this.getAttribute('data-kt-user-id'));
        }
    });
});

// Add click event listener to update buttons
document.querySelectorAll('[data-kt-action="update_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        // Livewire.emit('update_user', this.getAttribute('data-kt-user-id'));
        Livewire.emit('update_user', this.getAttribute('data-kt-user-id'), this.getAttribute('data-kt-role-id'));

    });
});

// Listen for 'success' event emitted by Livewire
Livewire.on('success', (message) => {
    $('#kt_modal_assign_role').modal('hide');
    // Reload the users-table datatable
    LaravelDataTables['usersassingedrole-table'].ajax.reload();
});
