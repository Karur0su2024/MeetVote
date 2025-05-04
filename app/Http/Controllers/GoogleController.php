<?php

namespace App\Http\Controllers;

use App\Interfaces\Google\GoogleAuthServiceInterface;
use App\Interfaces\GoogleServiceInterface;
use App\Services\Google\GoogleService;

class GoogleController extends Controller
{

    public function __construct(public GoogleAuthServiceInterface $googleAuthService)
    {}

    public function redirectToOAuthGoogle()
    {
        return $this->googleAuthService->redirectToGoogleOAuth();
    }

    public function handleGoogleOAuthCallback()
    {
        return $this->googleAuthService->handleGoogleOAuthCallback();
    }

    public function redirectToCalendarGoogle()
    {
        return $this->googleAuthService->redirectToGoogleCalendar();
    }

    public function handleGoogleCalendarCallback()
    {
        return $this->googleAuthService->handleGoogleCalendarCallback();
    }


    public function disconnectFromGoogleOAuth()
    {
        return $this->googleAuthService->disconnectFromGoogleOAuth();
    }

    public function disconnectFromGoogleCalendar(GoogleServiceInterface $googleService)
    {
        return $this->googleAuthService->disconnectFromGoogleCalendar($googleService);
    }
}
