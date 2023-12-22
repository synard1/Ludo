<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\DashboardController;

// Route::middleware(['auth', 'role:Super Admin','DBlogQueries'])->group(function () {

// Route::middleware(['auth','DBlogQueries'])->group(function () {
Route::middleware(['auth'])->group(function () {
    // Your routes for Super Admin go here
    // Route::get('/', function () {
    //             return 'This is Super Admin';
    //         });


    Route::get('/', [DashboardController::class, 'index']);

    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('logs', App\Http\Controllers\LogController::class);
    Route::resource('user-infos', App\Http\Controllers\UserInfoController::class);

    Route::name('user-management.')->group(function () {
        Route::get('/user-management/permission/usersp', [PermissionManagementController::class, 'UserShow'])->name('permissions.UserShow');
        Route::post('/check-roles', [RoleManagementController::class, 'checkRoles']);

        Route::resource('/user-management/users', UserManagementController::class);

        Route::resource('/user-management/roles', RoleManagementController::class);
        // Route::resource('/user-management/permissions', Permissions::class);

        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::name('system.')->group(function () {
        Route::resource('/logs/audit-logs', App\Http\Controllers\LogController::class);
    });

    // Add more routes as needed
});
