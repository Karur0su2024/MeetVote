<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;


Route::prefix('/google')->group(function () {
    // Google routy
    Route::get('/', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

    Route::get('/disconnect', [GoogleController::class, 'disconnectFromGoogle'])
        ->middleware(['auth', 'verified'])
        ->name('google.disconnect');

});
