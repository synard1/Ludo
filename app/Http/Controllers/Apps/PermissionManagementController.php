<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\PermissionsDataTable;
use App\DataTables\UsersAssignedPermissionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use App\Models\Role;
use App\Models\User;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionsDataTable $dataTable,Role $roles)
    {
        addVendors(['datatables']);
        // return $dataTable->render('pages.apps.user-management.permissions.list');

        return $dataTable->with('roles', $roles)
            ->render('pages.apps.user-management.permissions.list', compact('roles'));

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
    public function UserShow(Permission $permission, UsersAssignedPermissionDataTable $dataTable, User $users)
    {
        addVendors(['datatables']);
        $users = User::all();
        return $dataTable
            ->render('pages.apps.user-management.permissions.listUser', compact(['permission','users']));
        // return $dataTable->with('permission', $permission)
        //     ->render('pages.apps.user-management.permission.listUser', compact(['permission','users']));
    }

    public function show()
    {
        // $users = User::all();
        return 'aa';
        // return $dataTable
        //     ->render('pages.apps.user-management.permissions.listUser');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
