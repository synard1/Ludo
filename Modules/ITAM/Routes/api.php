<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ITAM\Http\Controllers\AssetCategoryController;

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
    
});
