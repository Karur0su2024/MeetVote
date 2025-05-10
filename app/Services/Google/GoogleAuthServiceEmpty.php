<?php

namespace App\Services\Google;

use App\Interfaces\Google\GoogleAuthServiceInterface;
use App\Interfaces\GoogleServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class GoogleAuthServiceEmpty implements GoogleAuthServiceInterface
{

    public function redirectToGoogleOAuth()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleOAuthCallback()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function disconnectFromGoogleOAuth()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function redirectToGoogleCalendar()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('settings'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleCalendarCallback()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('settings'))->with('warning', 'Google service is not enabled.');
    }

    public function disconnectFromGoogleCalendar(GoogleServiceInterface $googleService)
    {
        Log::info('Google service is not enabled.');
        return redirect(route('settings'))->with('warning', 'Google service is not enabled.');
    }
}
