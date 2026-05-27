<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // registrační formulář
//    Route::view('register', 'pages.auth.registration')->name('register');
    Route::livewire('register', 'pages::auth.registration')->name('register');

    // login formulář
//    Route::view('login', 'pages.auth.login')->name('login');
    Route::livewire('login', 'pages::auth.login')->name('login');

    // reset hesla
//    Route::view('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Route::livewire('forgot-password', 'pages::auth.forgot-password')->name('password.request');

//    Route::get('auth.reset-password', [UserController::class, 'resetPassword'])->name('password.reset');
    Route::livewire('auth.reset-password', 'pages::auth.reset-password')->name('password.reset');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('user/logout', [UserController::class, 'logout'])->name('logout');

    // Dashboard
//    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::livewire('dashboard', 'pages::user.dashboard')->name('dashboard');


    // Nastavení uživatele
//    Route::get('settings', [UserController::class, 'settings'])->name('settings');

    Route::livewire('settings', 'pages::user.settings')->name('settings');
});
