<?php

namespace App\Http\Controllers;

use App\Interfaces\GoogleServiceInterface;

class GoogleController extends Controller
{
    public GoogleServiceInterface $googleService;

    public function __construct(GoogleServiceInterface $googleService)
    {
        $this->googleService = $googleService;
    }

    public function redirectToGoogle()
    {
        return $this->googleService->redirectToGoogle();
    }

    public function handleGoogleCallback()
    {
        return $this->googleService->handleGoogleCallback();
    }

    public function disconnectGoogle()
    {
        $this->googleService->disconnectFromGoogle();
    }
}
