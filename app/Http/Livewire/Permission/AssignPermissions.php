<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class AssignPermissions extends Component
{
    public $roles;
    public $user_id;
    public $role_id;

    public Role $role;
    public Collection $permissions;

    public $name;
    public $checked_permissions;
    public $check_all;
    
    protected $rules = [
        'name' => 'required|string',
    ];

    // This is the list of listeners that this component listens to.
    protected $listeners = ['modal.show.user_id' => 'mountPermission'];

    public function render()
    {
        // Create an array of permissions grouped by ability.
        $permissions_by_group = [];
        foreach ($this->permissions ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');

            $permissions_by_group[$ability][] = $permission;
        }

        $users = User::all();
        // $permissions = Permission::all();
        $permissions = Permission::where('name', 'like', '%access%')->get();
        // Return the view with the permissions_by_group variable passed in.
        return view('livewire.permission.assign-permissions', compact('permissions_by_group'));
    }

    public function mountPermission($user_id = '')
    {
        if (empty($user_id)) {
            // If no user id is provided, initialize the properties with default values.
            $this->name = '';
            // $this->permissions = [];
            return;
        }

        // Get the user by their id.
        $user = User::find($user_id);
        $permission = Permission::all();

        // If the user is not found, initialize the properties with default values.
        if (is_null($user)) {
            $this->name = '';
            // $this->permissions = [];
            return;
        }

        // Set the name and permissions properties to the user's name and their permissions.
        $this->name = $user->name;
        $this->checked_permissions = $user->permissions->pluck('name')->toArray();

    }

    // This function is called when the component is mounted.
    public function mount()
    {
        // Get all permissions.
        // $this->permissions = Permission::all();
        $this->permissions = Permission::where('name', 'like', '%access%')->get();

        // Set the checked permissions property to an empty array.
        $this->checked_permissions = [];
    }

    // This function checks all of the permissions.
    public function checkAll()
    {
        // If the check_all property is true, set the checked permissions property to all of the permissions.
        if ($this->check_all) {
            $this->checked_permissions = $this->permissions->pluck('name');
        } else {
            // Otherwise, set the checked permissions property to an empty array.
            $this->checked_permissions = [];
        }
    }

    // public function submit()
    // {

    //     $this->emit('success', 'Permissions for ' . ucwords($this->name) . ' role updated');
    //     $this->resetForm();
    // }

    public function submit()
{
    // Find the user by name.
    $user = User::where('name', $this->name)->first();

    // If the user is found, sync their permissions.
    if ($user) {
        $user->syncPermissions($this->checked_permissions);

        $this->emit('success', 'Permissions for ' . ucwords($this->name) . ' have been updated');
    } else {
        $this->emit('error', 'User ' . ucwords($this->name) . ' not found');
    }

    $this->resetForm();
}

    private function resetForm()
    {
        // Reset the $name property to an empty string
        $this->name = '';
        }
}
