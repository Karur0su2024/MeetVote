<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = Auth::user();

        if($user) {
            $existingUser = User::where('google_id', $googleUser->getId())->first();

            if (!$existingUser) {
                return redirect('/settings')->with('error', 'Your Google account is already linked to another user.');
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'avatar' => $googleUser->getAvatar(),
                ]);

                return redirect('/settings');
            }
        }

        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ],
            [
                'name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
                'google_token' => $googleUser->token,
            ]
        );

        // Ulož token pro budoucí použití
        Auth::login($user, true);
        //return redirect('/dashboard');
    }

    public function disconnectGoogle()
    {

        $user = Auth::user();
        $user->google_id = null;
        $user->google_token = null;
        $user->save();

        return redirect('/settings')->with('success', 'Google account disconnected successfully.');
    }
}
