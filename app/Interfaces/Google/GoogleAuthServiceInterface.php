<?php

namespace App\Interfaces\Google;

use App\Interfaces\GoogleServiceInterface;

interface GoogleAuthServiceInterface
{

    public function redirectToGoogleOAuth();

    public function handleGoogleOAuthCallback();

    public function disconnectFromGoogleOAuth();

    public function redirectToGoogleCalendar();

    public function handleGoogleCalendarCallback();

    public function disconnectFromGoogleCalendar(GoogleServiceInterface $googleService);
}
