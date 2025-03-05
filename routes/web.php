<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;



require __DIR__ . '/auth.php';


// homepage
Route::view('/', 'pages.home')->name('home');

// poll create
Route::get('polls/create', [PollController::class, 'create'])
    ->name('polls.create');

// poll show
Route::get('polls/{poll}', [PollController::class, 'show'])
    ->middleware(['inviteOnly','checkPassword', 'isPollAdmin'])
    ->name('polls.show');

// poll edit
Route::get('polls/{poll}/edit', [PollController::class, 'edit'])
    ->middleware(['isPollAdmin'])
    ->name('polls.edit');

// dashboard
Route::get('dashboard', [UserController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// settings
Route::get('settings', [UserController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('settings');

// password
Route::get('polls/{poll}/authentification', [PollController::class, 'authentification'])
    ->name('polls.authentification');

Route::post('polls/{poll}/authentification', [PollController::class, 'checkPassword'])->name('polls.checkPassword');