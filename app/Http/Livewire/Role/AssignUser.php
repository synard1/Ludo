<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\User;
// use Spatie\Permission\Models\Role;
use App\Models\Role;

class AssignUser extends Component
{
    public $roles;
    public $users;
    public $user_id;
    public $role_id;
    public Role $role;
    public $name;


    // This is the list of listeners that this component listens to.
    protected $listeners = [
        'modal.show.role_name' => 'mountRole',
        'delete_user' => 'removeRoleFromUser'
    ];

    public function mountRole($role_name = '')
    {
        if (empty($role_name)) {
            // Handle new role creation or throw an error.
        }

        // Get the role by name.
        $role = Role::where('name', $role_name)->first();

        if (is_null($role)) {
            $this->emit('error', 'The selected role [' . $role_name . '] is not found');
            return;
        }

        $this->role = $role;
        $this->roles = Role::all();
        $this->users = User::doesntHave('roles')->get();
        // $this->users = User::whereDoesntHave('roles', function ($query) use ($role_name) {
        //     $query->where('name', $role_name);
        // })->get();
    }
    
    public function mount($role_name = '')
    {
        $excludedRoles = ['Super Admin'];
        $currentUserId = auth()->id();

        // If a role name is provided, call mountRole() to set the role and users.
        if (!empty($role_name)) {
            $this->mountRole($role_name);
        } else {
            // If no role name is provided, fetch all roles and all users without any specific role.
            $this->roles = Role::whereNotIn('name', $excludedRoles)->get();
            
            // Fetch all users who don't have any roles and their parent_id is equal to the current user's id.
            $this->users = User::whereDoesntHave('roles')
                                ->where('parent_id', $currentUserId)
                                ->get();
        }
    }

    // public function mount($role_name = '')
    // {
    //     $excludedRoles = ['Super Admin'];

    //     // If a role name is provided, call mountRole() to set the role and users.
    //     if (!empty($role_name)) {
    //         $this->mountRole($role_name);
    //     } else {
    //         // If no role name is provided, fetch all roles and all users without any specific role.
    //         $this->roles = Role::whereNotIn('name', $excludedRoles)->get();
    //         $this->users = User::whereDoesntHave('roles')->get();
    //     }
    // }

    // public function mount()
    // {
    //     $this->roles = Role::all();
    //     $this->users = User::all();
    // }

    public function render()
    {
        return view('livewire.role.assign-user');
    }

    public function updateRole()
    {
        $user = User::find($this->user_id);

        if ($user) {
            $role = Role::find($this->role_id);
            if ($role) {
                $user->syncRoles([$role->name]);
                $this->emit('success', 'User Role updated successfully.');
                // session()->flash('message', 'User role updated successfully.');
            } else {
                session()->flash('error', 'Role not found.');
            }
        } else {
            session()->flash('error', 'User not found.');
        }
    }

    public function removeRoleFromUser($user_id)
    {
        // Find the user and the role
        $user = User::find($user_id);
        // $role = Role::find($this->role_id);

        // Check if the user has any role
        if ($user->hasAnyRole(Role::all())) {
            // The user has at least one role
            // $user->removeRole($role->name);
            $user->syncRoles([]);
            $this->emit('success', 'User Role removed successfully.');
        } else {
            // The user does not have any role
            $this->emit('error', 'Cannot delete role. Role is being used by users.');
        }

        // If the user and the role exist, remove the role from the user
        // if ($user && $role) {
        //     $user->removeRole($role->name);

        //     // You can emit a success message or do a redirection here
        //     // session()->flash('message', 'User Role removed successfully.');
        //     $this->emit('success', 'User Role removed successfully.');
        // } else {
        //     // Emit an error message
        //     // session()->flash('error', 'User or role not found.');
        //     $this->emit('error', 'Cannot delete role. Role is being used by users.');
        // }
    }
}
