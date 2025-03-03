<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    

    //registrační formulář
    Route::view('register', 'pages.auth.registration')->name('register');

    //login formulář
    Route::view('login', 'pages.auth.login')->name('login');


    // Nutno předělat na normální stránku
    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    // Nutno předělat na normální stránku
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

