<?php

use Illuminate\Support\Facades\Route;
use Modules\SLA\Http\Controllers\SLAController;


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
//     Route::resource('sla', SLAController::class)->names('sla');
// })->middleware(['auth']);

Route::prefix('apps/sla')->name('sla.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // Main Routes
    Route::get('/', [SLAController::class, 'index'])->name('index');
    // Route::get('/workorder1', [WorkOrderController::class, 'index'])->name('workorder1');
    // Route::get('/workorder', [WorkOrderController::class, 'newIndex'])->name('workorder');
    // Route::get('/print/wo/{id}', [TicketController::class, 'woPrint'])->name('woPrint');

    // API
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/sla', [SLAController::class, 'getSlaData'])->name('getSla');
    //     Route::get('/ticket/statushistory', [TicketController::class, 'getStatusHistory'])->name('getStatusHistory');
        Route::post('/sla', [SLAController::class, 'saveSla'])->name('postSla');
    //     Route::post('/ticket', [TicketController::class, 'saveTicket'])->name('postTicket');
        Route::delete('/deleteSla/{id}', [SLAController::class, 'deleteSla'])->name('deleteSla');
    //     Route::get('/woresponse/{id}', [WorkOrderResponseController::class, 'getData'])->name('getWoResponse');
    //     Route::get('/workorder/staff', [WorkOrderController::class, 'getWorkOrderStaff'])->name('getWorkOrderStaff');
    //     Route::post('/workorder/response', [WorkOrderController::class, 'saveWorkOrderResponse'])->name('postWorkOrderResponse');
    //     Route::get('/workorder/notes', [WorkOrderNoteController::class, 'getWorkOrderNotes'])->name('getWorkOrderNotes');
    //     Route::post('/workorder/notes', [WorkOrderNoteController::class, 'saveWorkOrderNotes'])->name('postWorkOrderNotes');
    //     Route::get('/workorder', [WorkOrderController::class, 'getWorkOrderData'])->name('getWorkOrder');
    //     Route::post('/workorder', [WorkOrderController::class, 'saveWorkOrder'])->name('postWorkOrder');
    //     Route::delete('/deleteWorkOrder/{id}', [WorkOrderController::class, 'deleteWorkOrder'])->name('deleteWorkOrder');

    });

});
