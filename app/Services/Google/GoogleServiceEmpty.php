<?php

namespace App\Services\Google;

use App\Interfaces\GoogleServiceInterface;
use Laravel\Socialite\Two\User as GoogleUser;

class GoogleServiceEmpty implements GoogleServiceInterface
{

    public function redirectToGoogle()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleCallback()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function disconnectFromGoogle()
    {
        Log::info('Google service is not enabled.');
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function syncWithGoogleCalendar($users, $eventData)
    {
        // Synchronizace s Google kalendářem nebude provedena
        Log::info('Google service is not enabled.');
    }

    public function desyncWithGoogleCalendar($event)
    {
        Log::info('Google service is not enabled.');
    }

    public function checkAvailability($user, $option)
    {
        Log::info('Google service is not enabled.');
    }
}
