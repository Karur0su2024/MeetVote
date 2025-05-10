<?php

namespace App\Http\Controllers;

use App\Interfaces\Google\GoogleAuthServiceInterface;
use App\Interfaces\GoogleServiceInterface;
use App\Services\Google\GoogleService;

class GoogleController extends Controller
{

    public function __construct(public GoogleAuthServiceInterface $googleAuthService)
    {}

    // Přesměrování na Google OAuth pro přihlášení
    public function redirectToOAuthGoogle()
    {
        return $this->googleAuthService->redirectToGoogleOAuth();
    }

    // Zpracování callbacku z Google OAuth
    public function handleGoogleOAuthCallback()
    {
        return $this->googleAuthService->handleGoogleOAuthCallback();
    }

    // Přesměrování na na Google OAuth pro připojení Google Kalendáře
    public function redirectToCalendarGoogle()
    {
        return $this->googleAuthService->redirectToGoogleCalendar();
    }

    // Zpracování callbacku z Google Kalendáře
    public function handleGoogleCalendarCallback()
    {
        return $this->googleAuthService->handleGoogleCalendarCallback();
    }

    // Odpojení Google OAuth
    public function disconnectFromGoogleOAuth()
    {
        return $this->googleAuthService->disconnectFromGoogleOAuth();
    }

    // Odpojení Google Kalendáře
    public function disconnectFromGoogleCalendar(GoogleServiceInterface $googleService)
    {
        return $this->googleAuthService->disconnectFromGoogleCalendar($googleService);
    }
}
