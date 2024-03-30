<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

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

// Route::group([], function () {
//     Route::resource('dashboard', DashboardController::class)->names('dashboard');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard-report', [DashboardController::class, 'indexReport'])->middleware('auth')->name('dashboard.report');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
// });

Route::prefix('apps/dashboard')->name('dashboard.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // Main Routes
    // Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/test1', [DashboardController::class, 'incidentResolutionTimeChart'])->name('incidentResolutionTimeChart');
    Route::get('/test2', [DashboardController::class, 'averageTimeBySourceReport'])->name('averageTimeBySourceReport');

    // // API
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/fetch-data/dumpData', [DashboardController::class, 'dumpData'])->name('dumpData');
        Route::get('/fetch-data/report', [DashboardController::class, 'report'])->name('report');
        Route::get('/fetch-data/AverageTimeHisReport', [DashboardController::class, 'fetchDataAverageTimeHisReport'])->name('fetchDataAverageTimeHisReport');
        Route::get('/fetch-data/AverageTimeBySourceReport', [DashboardController::class, 'fetchDataAverageTimeBySourceReport'])->name('fetchDataAverageTimeBySourceReport');
        Route::get('/fetch-data/chart', [DashboardController::class, 'fetchDataAverageTimeByStaff'])->name('fetchDataAverageTimeByStaff');
        Route::get('/fetch-data/IncidentService', [DashboardController::class, 'getDataIncidentService'])->name('getDataIncidentService');


    });

});
