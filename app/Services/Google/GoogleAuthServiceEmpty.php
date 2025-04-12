<?php

namespace App\Services\Google;

use App\Interfaces\Google\GoogleAuthServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class GoogleAuthServiceEmpty implements GoogleAuthServiceInterface
{
    public function redirectToGoogle(): RedirectResponse
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function disconnectFromGoogle(): RedirectResponse
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }
}
