<?php

namespace App\Http\Controllers;

use App\Interfaces\Google\GoogleAuthServiceInterface;

class GoogleController extends Controller
{

    public function __construct(public GoogleAuthServiceInterface $googleAuthService)
    {}

    public function redirectToGoogle()
    {
        return $this->googleAuthService->redirectToGoogle();
    }

    public function handleGoogleCallback()
    {
        return $this->googleAuthService->handleGoogleCallback();
    }

    public function disconnectFromGoogle()
    {
        return $this->googleAuthService->disconnectFromGoogle();
    }
}
