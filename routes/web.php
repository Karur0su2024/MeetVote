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
// přidat middleware pro ověření, zda je uživatel autorizován
Route::get('polls/{poll}', [PollController::class, 'show'])
    ->name('polls.show');

// poll edit
// přidat middleware pro ověření, zda je uživatel autorizován
Route::get('polls/{poll}/edit', [PollController::class, 'edit'])
    ->name('polls.edit');

// dashboard
Route::get('dashboard', [UserController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// settings
Route::get('settings', [UserController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('settings');

