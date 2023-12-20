<?php

use Illuminate\Support\Facades\Route;
use Modules\Semver\Http\Controllers\SemverController;
use Modules\Semver\Http\Controllers\VersionController;
use Modules\Semver\Http\Controllers\ChangelogController;

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
//     Route::resource('semver', SemverController::class)->names('semver');
// });

Route::prefix('apps/semver')->name('semver.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // Main Routes
    Route::get('/version', [VersionController::class, 'index'])->name('version.index');
    Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog.index');

    // API
    // Route::prefix('api')->name('api.')->group(function () {
    //     Route::get('/ticket', [TicketController::class, 'getTicketData'])->name('getTicket');
    //     Route::get('/ticket/statushistory', [TicketController::class, 'getStatusHistory'])->name('getStatusHistory');
    //     Route::post('/ticket/status', [TicketController::class, 'saveStatus'])->name('postStatus');
    //     Route::post('/ticket', [TicketController::class, 'saveTicket'])->name('postTicket');
    //     Route::delete('/deleteTicket/{id}', [TicketController::class, 'deleteTicket'])->name('deleteTicket');
    //     Route::get('/woresponse/{id}', [WorkOrderResponseController::class, 'getData'])->name('getWoResponse');
    //     Route::get('/workorder/staff', [WorkOrderController::class, 'getWorkOrderStaff'])->name('getWorkOrderStaff');
    //     Route::post('/workorder/response', [WorkOrderController::class, 'saveWorkOrderResponse'])->name('postWorkOrderResponse');
    //     Route::get('/workorder/notes', [WorkOrderNoteController::class, 'getWorkOrderNotes'])->name('getWorkOrderNotes');
    //     Route::post('/workorder/notes', [WorkOrderNoteController::class, 'saveWorkOrderNotes'])->name('postWorkOrderNotes');
    //     Route::get('/workorder', [WorkOrderController::class, 'getWorkOrderData'])->name('getWorkOrder');
    //     Route::post('/workorder', [WorkOrderController::class, 'saveWorkOrder'])->name('postWorkOrder');
    //     Route::delete('/deleteWorkOrder/{id}', [WorkOrderController::class, 'deleteWorkOrder'])->name('deleteWorkOrder');

    // });

});
