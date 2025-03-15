<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::middleware(['setLanguage'])->group(function () {







// Domovská stránka
Route::view('/', 'pages.home')->name('home');

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

    // Heslo
    Route::get('/{poll}/authentification', [PollController::class, 'authentification'])
        ->name('polls.authentification');

    // Ověření hesla
    Route::post('/{poll}/authentification', [PollController::class, 'checkPassword'])->name('polls.checkPassword');
});


// Dashboard
Route::get('dashboard', [UserController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Nastavení uživatele
Route::get('settings', [UserController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('settings');



//Pozvánky
Route::get('invite/{token}', [PollController::class, 'openPollWithInvitation'])
    ->name('polls.invite');


// Dark mode, možná přesunout do controlleru
Route::get('/toggledarkmode', [AppController::class, 'toggleDarkMode'])->name('toggleDarkMode');

Route::get('/changeLanguage/{lang}', [AppController::class, 'changeLanguage'])
->name('changeLanguage');


Route::get('/error', function () {
    return view('pages.error');
})->name('errors');








});
