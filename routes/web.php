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
            ->middleware(['poll.is_invite_only', 'poll.has_password'])
            ->name('polls.show');

        // Úprava ankety
        Route::get('/{poll}/edit', [PollController::class, 'edit'])
            ->middleware(['poll.is_active', 'poll.has_access'])
            ->name('polls.edit');

        // Formulář pro ověření hesla ankety
        Route::get('/{poll}/authentication', [PollController::class, 'authentication'])->name('polls.authentication');

        // Přidat práva správce ankety pomocí odkazu
        Route::get('/{poll}/{admin_key}', [PollController::class, 'addAdmin'])->name('polls.show.admin');

        // Ověření hesla
        Route::post('/{poll}/authentication', [PollController::class, 'checkPassword'])->name('polls.checkPassword');

        // Smazání ankety
        Route::delete('/{poll}', [PollController::class, 'destroy'])
            ->name('polls.destroy');

    });

    //Pozvánky
    Route::get('invite/{token}', [PollController::class, 'openPollWithInvitation'])
        ->name('polls.invite');

    // Dark mode
    Route::get('/toggledarkmode', [AppController::class, 'toggleDarkMode'])->name('toggleDarkMode');

    // Změna jazyka
    Route::get('/changeLanguage/{lang}', [AppController::class, 'changeLanguage'])
        ->name('changeLanguage');
});
