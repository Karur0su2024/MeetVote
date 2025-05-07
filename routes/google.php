<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;


// Routy pro Google OAuth a Google Calendar
Route::prefix('/google')->group(function () {
    // Google routy
    Route::get('/oauth', [GoogleController::class, 'redirectToOAuthGoogle'])->name('google.oath.login');
    Route::get('/oauth/callback', [GoogleController::class, 'handleGoogleOAuthCallback'])->name('google.oauth.callback');

    Route::get('/calendar', [GoogleController::class, 'redirectToCalendarGoogle'])
        ->middleware(['google.connected'])
        ->name('google.calendar.login');
    Route::get('/calendar/callback', [GoogleController::class, 'handleGoogleCalendarCallback'])
        ->middleware(['google.connected'])
        ->name('google.calendar.callback');

    Route::get('/oauth/disconnect', [GoogleController::class, 'disconnectFromGoogleOAuth'])
        ->middleware(['google.connected'])
        ->name('google.oauth.disconnect');

    Route::get('/calendar/disconnect', [GoogleController::class, 'disconnectFromGoogleCalendar'])
        ->middleware(['google.connected'])
        ->name('google.calendar.disconnect');

});
