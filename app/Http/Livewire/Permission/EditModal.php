<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Role;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

class EditModal extends Component
{

    public $permission;
    public $name;
    public $selectedRoles = [];
    public $roles;

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'selectedRoles' => 'required|array',
        'selectedRoles.*' => 'integer|exists:roles,id',
    ];

    public function mount(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('id')->toArray();
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.permission.edit-modal');
    }

    public function updatePermission()
    {
        $this->validate();

        $this->permission->update([
            'name' => $this->name,
        ]);

        $this->permission->roles()->sync($this->selectedRoles);

        session()->flash('success', 'Permission updated successfully.');

        return redirect()->route('permissions.index');
    }

    public function close()
    {
        $this->reset(['name', 'roles']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

//     public function delete($name)
// {
//     $permission = Permission::where('name', $name)->first();

//     if (!is_null($permission)) {
//         // Check if any roles are attached to the permission
//         if ($permission->roles()->exists()) {
//             $this->emit('error', 'Cannot delete the permission because it is attached to one or more roles.');
//         } else {
//             // Check if any users are assigned the permission
//             if ($permission->users()->exists()) {
//                 $this->emit('error', 'Cannot delete the permission because it is assigned to one or more users.');
//             } else {
//                 // Delete the permission if there are no roles or users attached to it
//                 $permission->delete();
//                 $this->emit('success', 'Permission deleted');
//             }
//         }
//     }
// }
}
