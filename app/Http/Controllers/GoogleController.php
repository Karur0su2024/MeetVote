<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\GoogleServiceInterface;
use App\Services\GoogleService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

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
