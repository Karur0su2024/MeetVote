<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;

Route::middleware('guest')->group(function () {

    // registrační formulář
    Route::view('register', 'pages.auth.registration')->name('register');

    // login formulář
    Route::view('login', 'pages.auth.login')->name('login');

    Route::view('forgot-password', 'pages.auth.forgot-password')->name('password.request');

    Route::view('reset-password', 'pages.auth.reset-password')->name('password.reset');

    // Google OAuth




});


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::get('/user/google/disconnect', [GoogleController::class, 'disconnectGoogle'])
    ->name('google.disconnect');

});

