<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

// Middleware pro nastavení jazyka
Route::middleware(['setLanguage'])->group(function () {

    // Routy pro autentizaci
    require __DIR__ . '/auth.php';

    // Domovská stránka
    Route::view('/', 'pages.home')->name('home');

    // Všechny routy pro ankety
    Route::prefix('polls')->group(function () {

        // Vytvoření ankety
        Route::get('/create', [PollController::class, 'create'])
            ->name('polls.create');

        // Zobrazení ankety
        Route::get('/{poll}', [PollController::class, 'show'])
            ->middleware(['isPollAdmin', 'inviteOnly', 'checkPassword'])
            ->name('polls.show');

        // Úprava ankety
        Route::get('/{poll}/edit', [PollController::class, 'edit'])
        ->middleware(['poll.is_active', 'isPollAdmin'])
        ->name('polls.edit');

        // Přidat práva správce ankety pomocí odkazu
        Route::get('/{poll}/{admin_key}', [PollController::class, 'addAdmin'])->name('polls.show.admin');
        //

        // Heslo ankety
        Route::get('/{poll}/authentification', [PollController::class, 'authentification'])
            ->name('polls.authentification');

        // Ověření hesla
        Route::post('/{poll}/authentification', [PollController::class, 'checkPassword'])->name('polls.checkPassword');
    });


    Route::middleware(['auth', 'verified'])->group(function (){

        // Dashboard
        Route::get('dashboard', [UserController::class, 'dashboard'])
            ->name('dashboard');

        // Nastavení uživatele
        Route::get('settings', [UserController::class, 'settings'])
            ->name('settings');
    });


    //Pozvánky
    Route::get('invite/{token}', [PollController::class, 'openPollWithInvitation'])
        ->name('polls.invite');

    // Dark mode
    Route::get('/toggledarkmode', [AppController::class, 'toggleDarkMode'])->name('toggleDarkMode');

    // Změna jazyka
    Route::get('/changeLanguage/{lang}', [AppController::class, 'changeLanguage'])
    ->name('changeLanguage');

    // Chybová stránka
    Route::get('/error', function () {
        return view('pages.error');
    })->name('errors');

});
