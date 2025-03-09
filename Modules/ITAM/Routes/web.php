<?php

use Illuminate\Support\Facades\Route;
use Modules\ITAM\Http\Controllers\ITAMontroller;
use Modules\ITSM\Http\Controllers\ITSMController;
use Modules\ITSM\Http\Controllers\IncidentController;
use Modules\ITSM\Http\Controllers\ServiceController;
use Modules\ITSM\Http\Controllers\LogBookController;
use Modules\ITSM\Http\Controllers\WorkOrderController;
use Modules\ITSM\Http\Controllers\WorkorderResponseController;

use Modules\ITAM\Http\Controllers\DepartmentController;
use Modules\ITAM\Http\Controllers\ManufactureController;
use Modules\ITAM\Http\Controllers\LocationController;
use Modules\ITAM\Http\Controllers\PartnerController;
use Modules\ITAM\Http\Controllers\TechnicianController;
use Modules\ITAM\Http\Controllers\UserController;
use Modules\ITAM\Http\Controllers\AssetCategoryController;
use Modules\ITAM\Http\Controllers\AssetController;
use Modules\ITAM\Http\Controllers\AssetTrackingController;
use Modules\ITAM\Http\Controllers\AssetHistoryController;


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

Route::prefix('apps/itam')->name('itam.')->middleware(config('onexolution.route.middleware'))->group(function () {

    // JSON Template Example (You can load this from a file or database)
$assetTemplate = [
    'computer' => [
        'fields' => [
            ['name' => 'asset_tag', 'label' => 'Asset Tag', 'type' => 'text', 'required' => true],
            ['name' => 'model', 'label' => 'Model', 'type' => 'text'],
            ['name' => 'serial_number', 'label' => 'Serial Number', 'type' => 'text'],
            ['name' => 'cpu', 'label' => 'CPU', 'type' => 'dynamic', 'max_options' => 1, 'fields' => [
                ['name' => 'cpu_model', 'label' => 'CPU Model', 'type' => 'text'],
                ['name' => 'cpu_speed', 'label' => 'CPU Speed', 'type' => 'text'],
            ]],
            ['name' => 'ram', 'label' => 'RAM', 'type' => 'dynamic', 'fields' => [
                ['name' => 'ram_size', 'label' => 'RAM Size', 'type' => 'text'],
                ['name' => 'ram_type', 'label' => 'RAM Type', 'type' => 'text'],
            ]],
            // ... other computer fields
        ],
    ],
    'server' => [
        'fields' => [
            ['name' => 'asset_tag', 'label' => 'Asset Tag', 'type' => 'text', 'required' => true],
            ['name' => 'model', 'label' => 'Model', 'type' => 'text'],
            ['name' => 'serial_number', 'label' => 'Serial Number', 'type' => 'text'],
            ['name' => 'cpu', 'label' => 'CPU', 'type' => 'dynamic', 'max_options' => 4, 'fields' => [
                ['name' => 'cpu_model', 'label' => 'CPU Model', 'type' => 'text'],
                ['name' => 'cpu_speed', 'label' => 'CPU Speed', 'type' => 'text'],
            ]],
            ['name' => 'ram', 'label' => 'RAM', 'type' => 'dynamic', 'fields' => [
                ['name' => 'ram_size', 'label' => 'RAM Size', 'type' => 'text'],
                ['name' => 'ram_type', 'label' => 'RAM Type', 'type' => 'text'],
            ]],
            // ... other server fields
        ],
    ],
    'monitor' => [
        'fields' => [
            ['name' => 'asset_tag', 'label' => 'Asset Tag', 'type' => 'text', 'required' => true],
            ['name' => 'model', 'label' => 'Model', 'type' => 'text'],
            ['name' => 'serial_number', 'label' => 'Serial Number', 'type' => 'text'],
            ['name' => 'screen_size', 'label' => 'Screen Size', 'type' => 'text'],
            // ... other monitor fields
        ],
    ],
];

function generateForm($assetType, $template) {
    if (!isset($template[$assetType])) {
        return "Asset type not found.";
    }

    $fields = $template[$assetType]['fields'];
    $form = '<form method="POST" action="/assets/store">';
    $form .= csrf_field();
    $form .= '<input type="hidden" name="asset_type" value="' . $assetType . '">';

    foreach ($fields as $field) {
        $form .= '<div class="form-group">';
        $form .= '<label for="' . $field['name'] . '">' . $field['label'] . '</label>';

        if ($field['type'] === 'dynamic') {
            $maxOptions = isset($field['max_options']) ? $field['max_options'] : null;
            $form .= '<div id="' . $field['name'] . '-container">';
            $form .= '<button type="button" onclick="addDynamicField(\'' . $field['name'] . '\', ' . json_encode($field['fields']) . ', ' . json_encode($maxOptions) . ')">Add ' . $field['label'] . '</button>';
            $form .= '<div id="' . $field['name'] . '-fields"></div>';
            $form .= '</div>';
        }

        // if ($field['type'] === 'text') {
        //     $form .= '<input type="text" name="' . $field['name'] . '" id="' . $field['name'] . '" class="form-control" ' . (isset($field['required']) && $field['required'] ? 'required' : '') . '>';
        // } elseif ($field['type'] === 'dynamic') {
        //     $maxOptions = isset($field['max_options']) ? $field['max_options'] : null;
        //     $form .= '<div id="' . $field['name'] . '-container">';
        //     $form .= '<button type="button" onclick="addDynamicField(\'' . $field['name'] . '\', \'' . json_encode($field['fields']) . '\', ' . json_encode($maxOptions) . ')">Add ' . $field['label'] . '</button>';
        //     $form .= '<div id="' . $field['name'] . '-fields"></div>';
        //     $form .= '</div>';
        // }

        $form .= '</div>';
    }

    $form .= '<button type="submit" class="btn btn-primary">Submit</button>';
    $form .= '</form>';

    return $form;
}
    // Main Routes
    Route::get('/department', [DepartmentController::class, 'index'])->name('department');
    Route::get('/manufacturer', [ManufactureController::class, 'index'])->name('manufacturer');
    Route::get('/asset', [AssetController::class, 'index'])->name('asset');
    Route::get('/logbook', [LogBookController::class, 'index'])->name('logbook');
    Route::get('/workorder', [WorkOrderController::class, 'index'])->name('workorder');
    // Route::get('/workorder', function () {
    //     return view('itsm::workorder.index');
    // });
    // Route::get('/print/wo/{id}', [WorkOrderController::class, 'woPrint'])->name('woPrint');
    Route::get('/print/wo/{filename}', [WorkOrderController::class, 'printWorkOrder'])->name('print.workorder');

    Route::get('/form/{assetType}', function ($assetType) use ($assetTemplate) {
        return generateForm($assetType, $assetTemplate);
    });

    // Route::get('/print/{filename}', 'WorkOrderController@printWorkOrder')->name('print.workorder');


    // API
    // Route::prefix('api')->name('api.')->group(function () {
    //     Route::get('/incidentCategories', [IncidentController::class, 'getAjax'])->name('incident.category.get');
    //     Route::post('/incidentCategories', [IncidentController::class, 'postAjax'])->name('incident.category.post');
    //     Route::delete('/incidentCategories', [IncidentController::class, 'deleteAjax'])->name('incident.category.destroy');

    //     Route::post('/services', [ServiceController::class, 'store'])->name('service.store');
    //     Route::get('/services', [ServiceController::class, 'edit'])->name('service.edit');
    //     Route::delete('/deleteService/{id}', [ServiceController::class, 'destroy'])->name('deleteService');

    //     Route::get('/serviceCategories', [ServiceController::class, 'getAjax'])->name('service.category.get');
    //     Route::post('/serviceCategories', [ServiceController::class, 'postAjax'])->name('service.category.post');
    //     Route::delete('/serviceCategories', [ServiceController::class, 'deleteAjax'])->name('service.category.destroy');

    //     Route::get('/incidents', [IncidentController::class, 'edit'])->name('incident.edit');
    //     Route::post('/incidents', [IncidentController::class, 'store'])->name('incident.store');

    //     Route::get('/workorder/response/{id}', [WorkorderResponseController::class, 'show'])
    //         ->name('workorder.response.show');
    //     Route::post('/workorder/response', [WorkorderResponseController::class, 'store'])
    //         ->name('workorder.response.store');
    //     Route::get('/workorder', [WorkOrderController::class, 'showAjax'])->name('workorder.showAjax');
    //     Route::post('/workorder', [WorkOrderController::class, 'store'])->name('workorder.store');
    //     Route::delete('/workorder/{id}', [WorkOrderController::class, 'destroy'])->name('workorder.destroy');
    //     Route::delete('/deleteIncident/{id}', [IncidentController::class, 'destroy'])->name('deleteIncident');
    // });

});


