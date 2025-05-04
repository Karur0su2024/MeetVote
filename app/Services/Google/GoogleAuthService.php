<?php

namespace App\Services\Google;

use App\Interfaces\Google\GoogleAuthServiceInterface;
use App\Interfaces\GoogleServiceInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;


class GoogleAuthService implements GoogleAuthServiceInterface
{

    public function redirectToGoogleOAuth()
    {
        return Socialite::driver('google')
            ->scopes(config('google.oauth_scopes'))->with(['access_type' => 'offline', 'prompt' => 'consent'])->redirect();
    }

    public function handleGoogleOAuthCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            if (Auth::check()) {
                return redirect(route('settings'))->with('error', 'Google authentication failed. Please try again.');
            }
            return redirect(route('login'))->with('error', 'Google authentication failed. Please try again.');
        }

        $user = $this->googleAccountAlreadyConnected($googleUser);


        if ($user) {
            if (Auth::check()) {
                return redirect(route('settings'))->with('error', 'Google account is already connected to another user.');
            }
            Auth::login($user, true);
            return redirect(route('dashboard'))->with('success', 'You were successfully logged in!');
        }


        if (Auth::check()) {
            $user = Auth::user();
            $user->update($this->buildGoogleUser($googleUser));
            return redirect(route('settings'))->with('success', 'Google account connected successfully.');
        } else {
            $user = $this->checkIfEmailExists($googleUser->getEmail());
            if ($user) {
                $user->update($this->buildGoogleUser($googleUser));
            } else {
                $user = User::create($this->buildGoogleUser($googleUser));
                event(new Registered($user));
            }
            Auth::login($user, true);
        }


        return redirect(route('home'));
    }

    public function disconnectFromGoogleOAuth()
    {
        $user = Auth::user();
        $user->google_id = null;
        $user->google_token = null;
        $user->google_refresh_token = null;
        $user->calendar_access = false;
        $user->save();

        return redirect(route('settings'))->with('success', 'Google account disconnected successfully.');
    }


    public function redirectToGoogleCalendar()
    {
        return Socialite::driver('google')
            ->scopes(config('google.calendar_scopes'))
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirectUrl(route('google.calendar.callback'))
            ->redirect();
    }

    public function handleGoogleCalendarCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(route('google.calendar.callback'))
                ->user();
        } catch (\Exception $e) {
            return redirect(route('settings'))->with('error', 'Google Calendar authentication failed. Please try again.');
        }

        $user = Auth::user();

        if ($googleUser->id === $user->google_id) {

            $user->update([
                'calendar_access' => true,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            return redirect(route('settings'))->with('success', 'Google Calendar access granted successfully.');
        }

        return redirect(route('settings'))->with('error', 'Google Calendar authentication failed. Please try again.');
    }

    public function disconnectFromGoogleCalendar(GoogleServiceInterface $googleService)
    {
        $user = Auth::user()->load('syncedEvents');
        $user->calendar_access = false;
        $user->save();

        $syncedEvent = $user->syncedEvents();

        foreach ($user->syncedEvents as $syncedEvent) {
            $googleService->desyncWithGoogleCalendar($syncedEvent->event);
        }

        return redirect(route('settings'))->with('success', 'Google Calendar access revoked successfully.');
    }


    private function buildGoogleUser(GoogleUser $googleUser, $user = null): array
    {
        $user = new User([
            'name' => $user->name ?? $googleUser->getName(),
            'email' => $user->email ?? $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);


        return $user->toArray();
    }

    private function googleAccountAlreadyConnected(GoogleUser $googleUser): ?User
    {
        return User::where('google_id', $googleUser->getId())->first();
    }

    private function checkIfEmailExists($email): ?User
    {
        return User::where('email', $email)->first();
    }
}
