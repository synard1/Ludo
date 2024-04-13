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

Route::prefix('userinfo')->group(function() {
    Route::get('/', 'UserInfoController@index');
});

Route::prefix('apps/userinfo')
    ->middleware('auth')
    ->name('userinfo.')
    ->group(function () {

    // Main Routes
    Route::get('/company', 'CompanyController@index')->name('company');

    // Route::get('/test', function () {
    //     return view('adsportal::index');
    // })->name('showTickets');

    // Route::get('/display/a', function () {
    //     return view('adsportal::showAds');
    // })->name('showAds');

    // Ads Routes
    // Route::prefix('ads')->group(function () {
    //     Route::get('/', [AdsController::class, 'index'])->name('index');
    //     Route::get('/image', [AdsController::class, 'indexImage'])->name('image');
    //     Route::get('/pending', [AdsController::class, 'indexPending'])->name('pending');
    //     Route::get('/data', [AdsController::class, 'getAdsScheduleData'])->name('data');
    // });

    // // Ads Schedule Routes
    // Route::get('/getadsschedule', [AdsController::class, 'getAdsScheduleAdminData'])->name('getadsscheduleadmin');

    // // Ads Site Routes
    // Route::get('/sites', [AdsSiteController::class, 'index'])->name('sites');

    // // Ads Client Routes
    // Route::get('/client', [AdsClientController::class, 'index'])->name('client');
});
