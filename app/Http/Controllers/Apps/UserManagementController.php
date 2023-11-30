<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;


class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        addVendors(['datatables']);
        return $dataTable->render('pages.apps.user-management.users.list');
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
    public function show(User $user)
    {
        return view('pages.apps.user-management.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }


    public function saveUser(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID

        // $user = User::create([
        //     'name'          => Uc($request->input('name')),
        //     'email'         => $request->input('email'),
        //     'password'      => Hash::make($request->input('password')),
        //     'account_id'    => 'ID-'.generateRandomString(8),
        //     'cid'           => $cid,
        //     'parent_id'     => $user->id,
        // ]);

        // // Assign default role "trial" to the user
        // $user->assignRole('trial');

        // event(new Registered($request->roles));

        // // You can return a response, e.g., a success message
        // return response()->json(['message' => 'User saved or updated successfully']);

        try {
            $user = User::create([
                'name'          => Uc($request->input('name')),
                'email'         => $request->input('email'),
                'password'      => Hash::make($request->input('password')),
                'account_id'    => 'ID-'.generateRandomString(8),
                'cid'           => $user->cid,
                'parent_id'     => $user->id,
                'level_access'     => $request->input('access'),
                'subscription'     => $user->subscription,
            ]);

            // Assign default role "trial" to the user
            $user->assignRole('Support');

            event(new Registered($request->roles));

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'User saved or updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed']);
        }


    }
}
