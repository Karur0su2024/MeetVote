<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\PollSettings;
use App\Livewire\Pages\QuestionSettings;
use App\Http\Controllers\PollController;

Route::view('/', 'homepage')
    ->name('home');

Route::get(('polls/{poll}'), [PollController::class, 'show'])->name('polls.show');

Route::get(('polls/new/settings'), PollSettings::class)->name('polls.new.settings');

Route::get(('polls/new/questions'), QuestionSettings::class)->name('polls.new.questions');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
