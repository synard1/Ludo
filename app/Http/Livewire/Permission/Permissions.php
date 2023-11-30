<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\Role;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use App\DataTables\PermissionsDataTable;

class Permissions extends Component
{
    public $isOpen = false;
    public $name, $permissionId;

    public function index(PermissionsDataTable $dataTable,Role $roles)
    {
        // return $dataTable->render('pages.apps.user-management.permissions.list');

        return $dataTable->with('roles', $roles)
            ->render('pages.apps.user-management.permissions.list', compact('roles'));
        
    }

    public function render(PermissionsDataTable $dataTable)
    {
        return $dataTable->render('livewire.permission.permissions');
    }

    // public function render()
    // {
    //     $permissions = Permission::all();
    //     return view('livewire.permission.permissions', compact('permissions'));
    
    // }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->name = '';
        $this->permissionId = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Permission::updateOrCreate(['id' => $this->permissionId], [
            'name' => $this->name,
        ]);

        session()->flash('message', $this->permissionId ? 'Permission Updated Successfully.' : 'Permission Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $this->permissionId = $id;
        $this->name = $permission->name;
        $this->openModal();
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
