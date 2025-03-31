<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

// Middleware pro nastavení jazyka
Route::middleware(['setLanguage'])->group(function () {

    // Routy pro autentizaci
    require __DIR__ . '/auth.php';
    require __DIR__ . '/google.php';
    require __DIR__ . '/poll.php';

    // Domovská stránka
    Route::view('/', 'pages.home')->name('home');

    //Pozvánky
    Route::get('invite/{token}', [PollController::class, 'openPollWithInvitation'])
        ->name('polls.invite');

    // Dark mode
    Route::get('/toggledarkmode', [AppController::class, 'toggleDarkMode'])->name('toggleDarkMode');

    // Změna jazyka
    Route::get('/changeLanguage/{lang}', [AppController::class, 'changeLanguage'])
        ->name('changeLanguage');
});
