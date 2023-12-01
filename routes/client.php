<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;

Route::group(['domain' => '{client_id}.ludo.my.id', 'prefix' => 'c'], function () {
    // Your routes go here
    Route::get('/test', [SettingController::class, 'domainCheck'])->name('domainCheck');
});

