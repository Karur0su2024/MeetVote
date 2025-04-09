<?php

namespace App\Services\Google;

use App\Interfaces\GoogleServiceInterface;
use Laravel\Socialite\Two\User as GoogleUser;

class GoogleServiceEmpty implements GoogleServiceInterface
{

    public function redirectToGoogle()
    {
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleCallback()
    {
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function disconnectFromGoogle()
    {
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function syncWithGoogleCalendar($users, $eventData)
    {
        // Synchronizace s Google kalendářem nebude provedena
        return;
    }

    public function desyncWithGoogleCalendar($event)
    {
        return;
    }

    public function checkAvailability($user, $startTime, $endTime)
    {
        return;
    }
}
