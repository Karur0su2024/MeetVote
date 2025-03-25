<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

// Google routy
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/user/google/disconnect', [GoogleController::class, 'disconnectGoogle'])
    ->middleware(['auth', 'verified'])
    ->name('google.disconnect');
