<?php
use Illuminate\Support\Facades\Route;
use Modules\AdsPortal\Http\Controllers\AdsSiteController;
use Modules\AdsPortal\Http\Controllers\AdsClientController;
use Modules\AdsPortal\Http\Controllers\AdsController;
use Modules\AdsPortal\Http\Controllers\AdsPortalController;

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

// Route::prefix('apps/adsportal')->group(function() {
//     Route::get('/sites', 'AdsSiteController@index');
//     Route::get('/', 'AdsPortalController@index');

// });

// Route::get('/getads', [AdsController::class, 'getAdsScheduleData'])->name('adsportal.getads');

Route::prefix('ads')->middleware('auth')->name('adsp.')->group(function () {

    Route::get('/show/{sitename}/{id}', [AdsPortalController::class, 'showAds'])->name('adsportal.showAds');
    Route::get('/get/image/{siteId}', [AdsController::class, 'getAdsImage'])->name('adsportal.showAdsImage');
    // Route::get('/show/a', [AdsPortalController::class, 'showAds'])->name('adsportal.showAds');
    Route::get('/test/2', [AdsController::class, 'getAdsShowtime'])->name('adsportal.showAds');
    // Route::get('/test/3', [AdsController::class, 'getAdsImage'])->name('adsportal.showAdsImage');
    Route::get('/test/1', function () {
        return view('adsportal::test.modal-table');
    })->name('adsportal.showAds');
});

Route::prefix('apps/adsportal')
    ->middleware('auth')
    ->name('adsportal.')
    ->group(function () {

    // Main Routes
    Route::get('/', 'AdsPortalController@index');
    Route::get('/test', function () {
        return view('adsportal::index');
    })->name('showAds');

    Route::get('/display/a', function () {
        return view('adsportal::showAds');
    })->name('showAds');

    // Ads Routes
    Route::prefix('ads')->group(function () {
        Route::get('/', [AdsController::class, 'index'])->name('index');
        Route::get('/image', [AdsController::class, 'indexImage'])->name('image');
        Route::get('/pending', [AdsController::class, 'indexPending'])->name('pending');
        Route::get('/data', [AdsController::class, 'getAdsScheduleData'])->name('data');
    });

    // Ads Schedule Routes
    Route::get('/getadsschedule', [AdsController::class, 'getAdsScheduleAdminData'])->name('getadsscheduleadmin');

    // Ads Site Routes
    Route::get('/sites', [AdsSiteController::class, 'index'])->name('sites');

    // Ads Client Routes
    Route::get('/client', [AdsClientController::class, 'index'])->name('client');
});


// Route::prefix('apps/adsportal')->middleware('auth')->name('adsportal.')->group(function () {
//     Route::get('/test', function () {
//         return view('adsportal::index');
//     })->name('adsportal.showAds');
//     Route::get('/getadsschedule', [AdsController::class, 'getAdsScheduleAdminData'])->name('adsportal.getadsscheduleadmin');
//     Route::get('/getads', [AdsController::class, 'getAdsScheduleData'])->name('adsportal.getads');
//     Route::get('/ads-image', [AdsController::class, 'indexImage'])->name('adsportal.ads-image');
//     Route::get('/ads-pending', [AdsController::class, 'indexPending'])->name('adsportal.ads-pending');
//     Route::get('/ads', [AdsController::class, 'index'])->name('adsportal.ads');
//     Route::get('/sites', [AdsSiteController::class, 'index'])->name('adsportal.sites');
//     Route::get('/client', [AdsClientController::class, 'index'])->name('adsportal.client');
//     Route::get('/display/a', function () {
//         return view('adsportal::showAds');
//     })->name('adsportal.showAds');
//     // Route::get('/show/a', [AdsClientController::class, 'index'])->name('adsportal.client');
//     Route::get('/', 'AdsPortalController@index');
// });
