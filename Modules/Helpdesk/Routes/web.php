<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Modules\Helpdesk\Http\Controllers\TicketController;
use Modules\Helpdesk\Http\Controllers\WorkOrderController;
use Modules\Helpdesk\Http\Controllers\WorkOrderResponseController;
use Modules\Helpdesk\Http\Controllers\WorkOrderNoteController;

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

Route::prefix('helpdesk')->group(function() {
    Route::get('/', 'HelpdeskController@index');
});

Route::prefix('apps/helpdesk')->name('helpdesk.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // Main Routes
    Route::get('/ticket', [TicketController::class, 'newIndex'])->name('tickets');
    Route::get('/test', [TicketController::class, 'test'])->name('test');
    // Route::get('/workorder1', [WorkOrderController::class, 'index'])->name('workorder1');
    Route::get('/workorder', [WorkOrderController::class, 'newIndex'])->name('workorder');
    Route::get('/print/wo/{id}', [TicketController::class, 'woPrint'])->name('woPrint');

    //Tester
    Route::post('/broadcast-test', function () {
        $time = now();
        $message = 'Test broadcast ' . $time; 
        $ticketData = ['ticket_id' => 456, 'message' => $message, 'created_at' => $time];
        event(new \Modules\Helpdesk\Events\NewTicketEvent($ticketData));
        broadcast(new \Modules\Helpdesk\Events\NewTicketEvent($ticketData));
        return response()->json(['message' => 'Broadcast sent']);
    });

    // API
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/ticket', [TicketController::class, 'getTicketData'])->name('getTicket');
        Route::get('/ticket/statushistory', [TicketController::class, 'getStatusHistory'])->name('getStatusHistory');
        Route::post('/ticket/status', [TicketController::class, 'saveStatus'])->name('postStatus');
        Route::post('/ticket', [TicketController::class, 'saveTicket'])->name('postTicket');
        Route::delete('/deleteTicket/{id}', [TicketController::class, 'deleteTicket'])->name('deleteTicket');
        Route::get('/woresponse/{id}', [WorkOrderResponseController::class, 'getData'])->name('getWoResponse');
        Route::get('/workorder/staff', [WorkOrderController::class, 'getWorkOrderStaff'])->name('getWorkOrderStaff');
        Route::post('/workorder/response', [WorkOrderController::class, 'saveWorkOrderResponse'])->name('postWorkOrderResponse');
        Route::get('/workorder/notes', [WorkOrderNoteController::class, 'getWorkOrderNotes'])->name('getWorkOrderNotes');
        Route::post('/workorder/notes', [WorkOrderNoteController::class, 'saveWorkOrderNotes'])->name('postWorkOrderNotes');
        Route::get('/workorder', [WorkOrderController::class, 'getWorkOrderData'])->name('getWorkOrder');
        Route::post('/workorder', [WorkOrderController::class, 'saveWorkOrder'])->name('postWorkOrder');
        Route::delete('/deleteWorkOrder/{id}', [WorkOrderController::class, 'deleteWorkOrder'])->name('deleteWorkOrder');

    });

});

// Route::group([
//     'prefix'        => 'apps/helpdesk',
//     'name'          => 'helpdesk.',
//     // 'namespace'     => config('onexolution.route.namespace'),
//     'middleware'    => config('onexolution.route.middleware'),
// ], function (Router $router) {

//     // Main Routes
//     Route::get('/ticket', 'TicketController@index')->name('tickets');
//     Route::get('/workorder', 'WorkOrderController@index')->name('workorder');
//     Route::get('/print/wo/{id}', 'TicketController@woPrint')->name('woPrint');

//     // API
//     Route::prefix('/api')->group(function () {
//         Route::get('/ticket', 'TicketController@getTicketData')->name('getTicket');
//         Route::post('/ticket', 'TicketController@saveTicket')->name('postTicket');
//         Route::get('/workorder/staff', 'WorkOrderController@getWorkOrderStaff')->name('getWorkOrderStaff');
//         Route::post('/workorder/response', 'WorkOrderController@saveWorkOrderResponse')->name('postWorkOrderResponse');
//         Route::get('/workorder', 'WorkOrderController@getWorkOrderData')->name('getWorkOrder');
//         Route::post('/workorder', 'WorkOrderController@saveWorkOrder')->name('postWorkOrder');
//         Route::delete('/deleteWorkOrder/{id}', 'WorkOrderController@deleteWorkOrder')->name('deleteWorkOrder');
//     });

// });
// Route::prefix('apps/helpdesk')
//     // ->middleware('auth')
//     ->name('helpdesk.')
//     ->group($attributes, function () {

//     // Main Routes
//     // Route::get('/ticket', 'TicketController@index')->name('tickets');
//     // Route::get('/workorder', 'WorkOrderController@index')->name('workorder');
//     // Route::get('/print/wo/{id}', 'TicketController@woPrint')->name('woPrint');

//     // API
//     Route::prefix('/api')->group(function () {
//         Route::get('/ticket', 'TicketController@getTicketData')->name('getTicket');
//         Route::post('/ticket', 'TicketController@saveTicket')->name('postTicket');
//         Route::get('/workorder/staff', 'WorkOrderController@getWorkOrderStaff')->name('getWorkOrderStaff');
//         Route::post('/workorder/response', 'WorkOrderController@saveWorkOrderResponse')->name('postWorkOrderResponse');
//         Route::get('/workorder', 'WorkOrderController@getWorkOrderData')->name('getWorkOrder');
//         Route::post('/workorder', 'WorkOrderController@saveWorkOrder')->name('postWorkOrder');
//         Route::delete('/deleteWorkOrder/{id}', 'WorkOrderController@deleteWorkOrder')->name('deleteWorkOrder');
//     });


// });
