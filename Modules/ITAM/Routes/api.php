<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ITAM\Http\Controllers\AssetCategoryController;
use Modules\ITAM\Http\Controllers\AssetTypeController;
use Modules\ITAM\Http\Controllers\ManufactureController;
use Modules\ITAM\Http\Controllers\DepartmentController;
use Modules\ITAM\Http\Controllers\LocationController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('itam', fn (Request $request) => $request->user())->name('itam');
    Route::get('itam/get-asset-types/{id}', [AssetCategoryController::class, 'getAssetTypes'])->name('itam.asset.type');

    Route::get('itam/category', [AssetCategoryController::class, 'getItamCategory'])->name('itam.asset.category');
    Route::delete('itam/category/{id}', [AssetCategoryController::class, 'destroy']);
    Route::get('/itam/category/{id}/edit', [AssetCategoryController::class, 'edit']);
    Route::put('/itam/category/{id}', [AssetCategoryController::class, 'update']);
    Route::post('/itam/category', [AssetCategoryController::class, 'store'])->middleware('auth');

    Route::get('itam/type', [AssetTypeController::class, 'getAjax'])->name('itam.asset.type');
    Route::delete('itam/type/{id}', [AssetTypeController::class, 'destroy']);
    Route::get('/itam/type/{id}/edit', [AssetTypeController::class, 'edit']);
    Route::put('/itam/type/{id}', [AssetTypeController::class, 'update']);
    Route::post('/itam/type', [AssetTypeController::class, 'store'])->middleware('auth');

    Route::post('/itam/manufacturer', [ManufactureController::class, 'store'])->middleware('auth');
    Route::get('/itam/manufacturer/{id}/edit', [ManufactureController::class, 'edit']);
    Route::put('/itam/manufacturer/{id}', [ManufactureController::class, 'update']);
    Route::delete('itam/manufacturer/{id}', [ManufactureController::class, 'destroy']);

    Route::post('/itam/department', [DepartmentController::class, 'store'])->middleware('auth');
    Route::get('/itam/department/{id}/edit', [DepartmentController::class, 'edit']);
    Route::put('/itam/department/{id}', [DepartmentController::class, 'update']);
    Route::delete('itam/department/{id}', [DepartmentController::class, 'destroy']);

    Route::post('/itam/location', [LocationController::class, 'store'])->middleware('auth');
    Route::get('/itam/location/{id}/edit', [LocationController::class, 'edit']);
    Route::put('/itam/location/{id}', [LocationController::class, 'update']);
    Route::delete('itam/location/{id}', [LocationController::class, 'destroy']);








    
});
