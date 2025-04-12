<?php

namespace App\Services\Google;

use App\Interfaces\GoogleServiceInterface;
use Laravel\Socialite\Two\User as GoogleUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class GoogleServiceEmpty implements GoogleServiceInterface
{
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
