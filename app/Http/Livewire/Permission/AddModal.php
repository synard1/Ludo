<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Role;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AddModal extends Component
{
    public $name;

    public Permission $permission;

    protected $rules = [
        'name' => 'required|string',
    ];

    // This is the list of listeners that this component listens to.
    protected $listeners = [
        'modal.show.permission_name' => 'mountPermission',
        'delete_permission' => 'delete'
    ];

    public function render()
    {
        return view('livewire.permission.add-modal');
    }

    public function mountPermission($permission_name = '')
    {
        if (empty($permission_name)) {
            // Create new
            $this->permission = new Permission;
            $this->name = '';
            return;
        }

        // Get the role by name.
        $permission = Permission::where('name', $permission_name)->first();
        if (is_null($permission)) {
            $this->emit('error', 'The selected permission [' . $permission_name . '] is not found');
            return;
        }

        $this->permission = $permission;

        // Set the name and checked permissions properties to the role's values.
        $this->name = $this->permission->name;
    }

    public function mount($permission = null)
    {
        $this->permission = $permission ?: new Permission();
    }

    public function submit()
{
    $this->validate();

    DB::transaction(function () {
        $this->permission->name = strtolower($this->name);
        $this->permission->save();

        // Emit a success event with a message indicating that the permissions have been updated.
        $this->emit('success', 'Permission Added1 Successfully');
    });

    // Reset the form fields after successful submission
    $this->resetForm();
}

private function resetForm()
{
    // Reset the $name property to an empty string
    $this->name = '';

    // Reset the $permission property to a new Permission instance
    $this->permission = new Permission();
}

public function delete($name)
    {
        $permission = Permission::where('name', $name)->first();
    
        if (!is_null($permission)) {
            // Check if any roles are attached to the permission
            if ($permission->roles()->exists()) {
                $this->emit('error', 'Cannot delete the permission because it is attached to one or more roles.');
            } else {
                // Check if any users are assigned the permission
                if ($permission->users()->exists()) {
                    $this->emit('error', 'Cannot delete the permission because it is assigned to one or more users.');
                } else {
                    // Delete the permission if there are no roles or users attached to it
                    $permission->delete();
                    $this->emit('success', 'Permission deleted');
                }
            }
        }
    }
}

