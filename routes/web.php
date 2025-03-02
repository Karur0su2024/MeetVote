<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


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