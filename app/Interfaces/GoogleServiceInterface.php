<?php

namespace App\Interfaces;

use App\Models\User;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

interface GoogleServiceInterface
{

    public function redirectToGoogle();


    public function handleGoogleCallback();

    public function disconnectFromGoogle();

    public function syncWithGoogleCalendar($users, $eventData);
}
