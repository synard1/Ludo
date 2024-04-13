<?php

namespace App\Http\Livewire\Permission;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
// use Spatie\Permission\Models\Role;
use App\Models\Role;

class RoleList extends Component
{
    public array|Collection $roles;


    protected $listeners = [
        'success' => 'updateRoleList',
        'deleteRole' => 'deleteRole'
    ];

    // public function render()
    // {
    //     $this->roles = Role::with('permissions')->get();

    //     return view('livewire.permission.role-list');
    // }
    public function render()
{
    // Check if the current user has the "Super Admin" role
    $hasSuperAdminRole = auth()->user()->hasRole('Super Admin');

    // Load roles along with their permissions
    $this->roles = Role::with('permissions')
                      ->where(function ($query) use ($hasSuperAdminRole) {
                          // If the current user doesn't have the "Super Admin" role,
                          // exclude the "Super Admin" role from the query
                          if (!$hasSuperAdminRole) {
                              $query->where('name', '<>', 'Super Admin');
                          }
                      })
                      ->get();

    return view('livewire.permission.role-list');
}

    public function updateRoleList()
    {
        $this->roles = Role::with('permissions')->get();
    }

    public function deleteRole($id)
{
    // Get the role by ID
    $role = Role::find($id);

    // Check if the role exists
    if (!$role) {
        $this->emit('error', 'Role not found');
        return;
    }

    // Check if the role is being used by any permissions
    if ($role->permissions->count() > 0) {
        $this->emit('error', 'Cannot delete role. Role is being used by permissions.');
        return;
    }

    // Check if the role is being used by any users
    if ($role->users->count() > 0) {
        $this->emit('error', 'Cannot delete role. Role is being used by users.');
        return;
    }

    // If there are no permissions or users using this role, delete it
    $role->delete();

    // Emit a success event
    $this->emit('success', 'Role deleted successfully');
}
}
