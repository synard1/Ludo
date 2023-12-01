<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Check if the environment is local or production
// if (app()->environment('local')) {
//     Route::domain('dev.ludo.my.id')->group(function () {
//         // API
//         Route::prefix('/{client_id}')->group(function () {
//             // Pass the client_id parameter for login route
//             // Route::get('login', [AuthenticatedSessionController::class, 'create'])
//             //     ->name('login')
//             //     ->where('client_id', '[0-9]+'); // Adjust the pattern accordingly

//             // Route::post('login', [AuthenticatedSessionController::class, 'store']);

//             Route::get('/test', [SettingController::class, 'domainCheck'])
//                 ->name('domainCheck');
//         });
//     });
if (app()->environment('production')) {
    // Production environment
    Route::domain('{client_id}.ludo.my.id')->group(function () {
        Route::get('/', [SettingController::class, 'domainCheck'])->name('domainCheck');
    });
}

