<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Mail\PollCreatedConfirmationEmail;
use App\Models\Poll;
use Illuminate\Support\Facades\Mail;

require __DIR__.'/auth.php';

// Domovská stránka
Route::view('/', 'pages.home')->name('home');

// Vytvoření ankety
Route::get('polls/create', [PollController::class, 'create'])
    ->name('polls.create');

// Zobrazení ankety
Route::get('polls/{poll}', [PollController::class, 'show'])
    ->middleware(['inviteOnly', 'checkPassword', 'isPollAdmin'])
    ->name('polls.show');

// Úprava ankety
Route::get('polls/{poll}/edit', [PollController::class, 'edit'])
    ->middleware(['isPollAdmin'])
    ->name('polls.edit');

// Dashboard
Route::get('dashboard', [UserController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Nastavení uživatele
Route::get('settings', [UserController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('settings');

// Heslo
Route::get('polls/{poll}/authentification', [PollController::class, 'authentification'])
    ->name('polls.authentification');

// Ověření hesla
Route::post('polls/{poll}/authentification', [PollController::class, 'checkPassword'])->name('polls.checkPassword');

// Přidat práva správce ankety pomocí odkazu
Route::get('polls/{poll}/{admin_key}', [PollController::class, 'addAdmin'])->name('polls.show.admin');
//



Route::get('/odeslat-email', function () {
    $data = Poll::find(1); // Zde nahraďte ID ankety, kterou chcete odeslat

    Mail::to('kareltynek2000@gmail.com')->send(new PollCreatedConfirmationEmail($data));

    return 'Nový e-mail byl úspěšně odeslán!';
});
