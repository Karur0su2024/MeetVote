<?php

use App\Http\Controllers\PollController;

use Illuminate\Support\Facades\Route;


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
        ->middleware(['poll.is_active', 'poll.can_edit'])
        ->name('polls.edit');

    // Formulář pro ověření hesla ankety
    Route::get('/{poll}/authentication', [PollController::class, 'authentication'])
        ->middleware(['poll.already_has_access'])
        ->name('polls.authentication');

    // Přidat práva správce ankety pomocí odkazu
    Route::get('/{poll}/{admin_key}', [PollController::class, 'addAdmin'])->name('polls.show.admin');

    // Ověření hesla
    Route::post('/{poll}/authentication', [PollController::class, 'checkPassword'])->name('polls.checkPassword');

    // Smazání ankety
    Route::delete('/{poll}', [PollController::class, 'destroy'])
        ->name('polls.destroy');

});
