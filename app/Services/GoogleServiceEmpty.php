<?php

namespace App\Services;

use App\Interfaces\GoogleServiceInterface;
use App\Models\SyncedEvent;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Models\Poll;
use Laravel\Socialite\Two\User as GoogleUser;

class GoogleServiceEmpty implements GoogleServiceInterface
{

    public function redirectToGoogle()
    {
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }

    public function handleGoogleCallback(GoogleUser $googleUser)
    {
        return redirect(route('home'))->with('warning', 'Google service is not enabled.');
    }
}
