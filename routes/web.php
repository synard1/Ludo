<?php

use App\Http\Controllers\Setting\CompanyController;

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Apps\SignaturePadController;
use Illuminate\Support\Facades\Route;
use \InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController;
use Symfony\Component\HttpFoundation\File\File;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/modules/{module}/{type}/{file}', [ function ($module, $type, $file) {

//     return 'aaaa';
// }]);

// Routes accessible only to users with "Super Admin" role
// Route::middleware(['auth', 'superAdmin'])->group(function () {
//     // Your protected routes go here
//     Route::get('/', function () {
//         return 'This is Super Admin';
//     });
// });

// Route::middleware(['auth', 'role:Super Admin'])->group(function () {
//     // Route::get('/', function () {
//     //     return 'This is Super Admin';
//     // });
//     Route::get('/', [DashboardController::class, 'index']);
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::resource('logs', App\Http\Controllers\LogController::class);
//     Route::resource('user-infos', App\Http\Controllers\UserInfoController::class);

//     Route::name('user-management.')->group(function () {
//         Route::resource('/user-management/users', UserManagementController::class);
//         Route::resource('/user-management/roles', RoleManagementController::class);
//         Route::resource('/user-management/permissions', PermissionManagementController::class);
//     });
// });

// Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
// Route::get('generator_builder', [GeneratorBuilderController::class, 'builder'])->name('io_generator_builder');
// Route::get('field_template', [GeneratorBuilderController::class, 'fieldTemplate'])->name('io_field_template');
// Route::get('relation_field_template', [GeneratorBuilderController::class, 'relationFieldTemplate'])->name('io_relation_field_template');
// Route::post('generator_builder/generate', [GeneratorBuilderController::class, 'generate'])->name('io_generator_builder_generate');
// Route::post('generator_builder/generate-from-file', [GeneratorBuilderController::class, 'generateFromFile'])->name('io_generator_builder_generate_from_file');
// Route::post('generator_builder/rollback', [GeneratorBuilderController::class, 'rollback'])->name('io_generator_builder_rollback');

// Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

// Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

// Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

// Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

// ×Fail! The POST method is not supported for route generator_builder/generate. Supported methods: GET, HEAD.


// Route::post(
//     'generator_builder/generate-from-file',
//     '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
// )->name('io_generator_builder_generate_from_file');


Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('logs', App\Http\Controllers\LogController::class);
    Route::resource('user-infos', App\Http\Controllers\UserInfoController::class);

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);

        // API
        // Route::prefix('/user-management/api')->group(function () {
        //     Route::post('/users', [UserManagementController::class, 'saveUser'])->name('postUser');

        // });
    });

    Route::name('apps.')->group(function () {
        Route::resource('/apps/signaturepad', SignaturePadController::class);

        // API
        // Route::prefix('/user-management/api')->group(function () {
        //     Route::post('/users', [UserManagementController::class, 'saveUser'])->name('postUser');

        // });
    });

    Route::name('settings.')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('index');
        Route::get('/settings/company', [CompanyController::class, 'index'])->name('company');

        // Route::resource('company', CompanyController::class,[
        //     'as' => 'company'
        // ]);

        // API
        Route::prefix('/setting/api')->group(function () {
            Route::get('/company', [SettingController::class, 'getCompany'])->name('getCompany');
            Route::get('/limit', [SettingController::class, 'getLimit'])->name('getLimit');
            Route::get('/version', [SettingController::class, 'getVersion'])->name('getVersion');
            Route::post('/company', [SettingController::class, 'saveCompany'])->name('postCompany');
            Route::put('/update-company-status/{id}', [SettingController::class, 'updateStatus'])->name('update-company-status');
            // Route::put('/update-company-status/{id}', 'SettingController@updateStatus')->name('update-company-status');
            // Route::post('/company', 'SettingController@saveCompany');

        });

    });

});



Route::get('/clear-cache/{cacheType?}', [SettingController::class, 'clearCache'])
                ->name('clear-cache');

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
require __DIR__.'/superadmin.php';





Route::resource('user-infos', App\Http\Controllers\UserInfoController::class);
