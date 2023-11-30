<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersAssignedRoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Role;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        addVendors(['datatables']);
        return view('pages.apps.user-management.roles.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role, UsersAssignedRoleDataTable $dataTable, User $users)
    {
        addVendors(['datatables']);
        $users = User::doesntHave('roles')->get();
        return $dataTable->with('role', $role)
            ->render('pages.apps.user-management.roles.show', compact(['role','users']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if($role){
            // check if the role is being used by a user
            if($role->users()->count() > 0) {
                return response()->json(['error' => 'This role is currently in use by a user and cannot be deleted'], 400);
            }

            // check if the role is being used by a permission
            if($role->permissions()->count() > 0) {
                return response()->json(['error' => 'This role is currently in use by a permission and cannot be deleted'], 400);
            }

            $role->delete();
            return response()->json(['success' => 'Role deleted successfully']);
        }

        return response()->json(['error' => 'This role is not exist'], 404);

    }

    public function checkRoles(Request $request)
    {
        $roles = $request->input('roles');

        // Perform your validation check here (e.g., check if the roles exist in the database)
        $existingRoles = Role::whereIn('name', explode(',', $roles))->pluck('name')->toArray();

        if (count(explode(',', $roles)) !== count($existingRoles)) {
            return response()->json('Invalid roles. Some roles do not exist.', 422);
        }

        $role = Role::create($roles);

        return response()->json('Roles validation successful.', 200);
    }
}
