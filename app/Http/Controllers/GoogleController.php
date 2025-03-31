<?php

namespace App\Http\Controllers;

use App\Interfaces\GoogleServiceInterface;

class GoogleController extends Controller
{

    public function __construct(public GoogleServiceInterface $googleService)
    {}

    public function redirectToGoogle()
    {
        return $this->googleService->redirectToGoogle();
    }

    public function handleGoogleCallback()
    {
        return $this->googleService->handleGoogleCallback();
    }

    public function disconnectFromGoogle()
    {
        return $this->googleService->disconnectFromGoogle();
    }
}
