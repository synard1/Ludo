<?php

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

Route::prefix('hotspot')->group(function() {
    Route::get('/', 'HotspotController@index');

    Route::group(['prefix' => '/l/{weblink}'], function () {
        Route::get('/', function ($weblink) {
           return 'Hi ' . $weblink;
        });
        Route::post('logon', 'HotspotController@login');
        // Route::post('logon', [HotspotController::class, 'login'])->name('hotspot.login');
        // Route::post('ajaxRequest', [HotspotUserController::class, 'ajaxRequestPost'])->name('hotspot.ajaxRequest');

    });
});


