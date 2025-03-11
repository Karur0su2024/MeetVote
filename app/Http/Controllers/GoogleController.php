<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->scopes([
            'openid',
            'email',
            'profile',
            'https://www.googleapis.com/auth/calendar',
            'https://www.googleapis.com/auth/calendar.events'
        ])->with(['access_type' => 'offline', 'prompt' => 'consent']) ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = Auth::user();

        if($user) {
            $existingUser = User::where('google_id', $googleUser->getId())->first();

            if ($existingUser) {
                return redirect('/settings')->with('error', 'Your Google account is already linked to another user.');
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                    'google_avatar' => $googleUser->getAvatar(),
                ]);


                return redirect('/settings');
            }
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if(!$user){
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'google_avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(16)), // generování náhodného hesla
            ]);
        }
        else {
            $user->update([
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'google_avatar' => $googleUser->getAvatar(),
            ]);
        }



        // Ulož token pro budoucí použití
        Auth::login($user, true);

        return redirect('/dashboard');
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
