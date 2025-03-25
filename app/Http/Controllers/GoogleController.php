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
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect(route('home'));
        }

        $this->googleService->handleGoogleCallback($googleUser);

        return redirect(route('home'));
    }

    public function disconnectGoogle()
    {
        // Případně odpojit všechny události

        $user = Auth::user();
        $user->google_id = null;
        $user->google_token = null;
        $user->save();

        return redirect()->back()->with('success', 'Google account disconnected successfully.');
    }
}
