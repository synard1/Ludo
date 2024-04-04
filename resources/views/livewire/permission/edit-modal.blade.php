<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPermissionForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_roles">Roles</label>
                        <select name="roles[]" id="edit_roles" class="form-control" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updatePermission()">Save</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
        <script>
            function openEditModal(id) {
                $.ajax({
                    url: '/permissions/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#edit_name').val(response.name);
                        $('#edit_roles').val(response.roles.map(role => role.id));
                        $('#editPermissionModal').modal('show');
                    },
                    error: function(error) {
                        // Handle error response
                    }
                });
            }

            function updatePermission() {
                let id = // get the permission ID here
                let formData = $('#editPermissionForm').serialize();
                $.ajax({
                    url: '/permissions/' + id,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        // Reload the page to see the updated permission in the list
                        location.reload();
                    },
                    error: function(error) {
                        // Handle validation errors or other error responses
                    }
                });
            }
        </script>
    @endpush