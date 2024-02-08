<?php

use Illuminate\Support\Facades\Route;
use Modules\ITSM\Http\Controllers\ITSMController;
use Modules\ITSM\Http\Controllers\IncidentController;
use Modules\ITSM\Http\Controllers\ServiceController;
use Modules\ITSM\Http\Controllers\LogBookController;
use Modules\ITSM\Http\Controllers\WorkOrderController;
use Modules\ITSM\Http\Controllers\WorkorderResponseController;

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
//     Route::resource('itsm', ITSMController::class)->names('itsm');
// });

Route::prefix('apps/itsm')->name('itsm.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // Main Routes
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/logbooks', [LogBookController::class, 'index'])->name('logbooks');
    Route::get('/workorder', [WorkOrderController::class, 'index'])->name('workorder');
    // Route::get('/print/wo/{id}', [WorkOrderController::class, 'woPrint'])->name('woPrint');
    Route::get('/print/wo/{filename}', [WorkOrderController::class, 'printWorkOrder'])->name('print.workorder');
    
    // Route::get('/print/{filename}', 'WorkOrderController@printWorkOrder')->name('print.workorder');


    // API
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/incidentCategories', [IncidentController::class, 'getAjax'])->name('incident.category.get');
        Route::post('/incidentCategories', [IncidentController::class, 'postAjax'])->name('incident.category.post');
        Route::delete('/incidentCategories', [IncidentController::class, 'deleteAjax'])->name('incident.category.destroy');

        Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/services', [ServiceController::class, 'edit'])->name('service.edit');
        Route::delete('/deleteService/{id}', [ServiceController::class, 'destroy'])->name('deleteService');

        Route::get('/serviceCategories', [ServiceController::class, 'getAjax'])->name('service.category.get');
        Route::post('/serviceCategories', [ServiceController::class, 'postAjax'])->name('service.category.post');
        Route::delete('/serviceCategories', [ServiceController::class, 'deleteAjax'])->name('service.category.destroy');

        Route::get('/incidents', [IncidentController::class, 'edit'])->name('incident.edit');
        Route::post('/incidents', [IncidentController::class, 'store'])->name('incident.store');

        Route::get('/logbooks', [LogBookController::class, 'edit'])->name('logbook.edit');
        Route::post('/logbooks', [LogBookController::class, 'store'])->name('logbook.store');
        Route::delete('/logbooks', [LogBookController::class, 'deleteAjax'])->name('logbook.destroy');

        Route::get('/workorder/response/{id}', [WorkorderResponseController::class, 'show'])
            ->name('workorder.response.show');
        Route::post('/workorder/response', [WorkorderResponseController::class, 'store'])
            ->name('workorder.response.store');
        Route::get('/workorder', [WorkOrderController::class, 'showAjax'])->name('workorder.showAjax');
        Route::post('/workorder', [WorkOrderController::class, 'store'])->name('workorder.store');
        Route::delete('/workorder/{id}', [WorkOrderController::class, 'destroy'])->name('workorder.destroy');
        Route::delete('/deleteIncident/{id}', [IncidentController::class, 'destroy'])->name('deleteIncident');
    });

});
