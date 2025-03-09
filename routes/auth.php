<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    // registrační formulář
    Route::view('register', 'pages.auth.registration')->name('register');

    // login formulář
    Route::view('login', 'pages.auth.login')->name('login');

    Route::view('forgot-password', 'pages.auth.forgot-password')->name('password.request');

    Route::view('reset-password', 'pages.auth.reset-password')->name('password.reset');

});
