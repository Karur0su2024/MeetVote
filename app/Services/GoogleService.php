<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

/**
 *
 */
class GoogleService
{
    /**
     * @var GoogleCalendarService
     */
    protected GoogleCalendarService $service;

    /**
     * @param GoogleCalendarService $googleCalendarService
     */
    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }


    /**
     * @return GoogleCalendarService
     */
    public function getGoogleCalendarService(): GoogleCalendarService
    {
        return $this->googleCalendarService;
    }


    /**
     * @return mixed
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'email',
                'profile',
                'https://www.googleapis.com/auth/calendar',
                'https://www.googleapis.com/auth/calendar.events'
            ])->with(['access_type' => 'offline', 'prompt' => 'consent']) ->redirect();
    }


    /**
     * Zpracuje požadavek Google po přihlášení
     * @param GoogleUser $googleUser
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object|null
     */
    public function handleGoogleCallback(GoogleUser $googleUser){

        if($this->googleAccountAlreadyConnected($googleUser)){
            return redirect('/settings')->with('error', 'Your Google account is already linked to another user.');
        }

        if(Auth::check()){
            $user = Auth::user();
            $user->update($this->buildGoogleUser($googleUser));
        }
        else {
            $user = User::create($this->buildGoogleUser($googleUser));
            Auth::login($user, true);
        }

        return $user;
    }


    /**
     * Vytvoří nového uživatele pro vložení
     * @param GoogleUser $googleUser
     * @param $user
     * @return array
     */
    private function buildGoogleUser(GoogleUser $googleUser, $user = null): array
    {
        $user = new User([
            'name' => $user->name ?? $googleUser->getName(),
            'email' => $user->email ?? $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'google_avatar' => $googleUser->getAvatar(),
        ]);


        return $user->toArray();
    }


    /**
     * Zkontroluje, zda není Google účet registrovaný již pod jiným účtem
     * @param $googleUser
     * @return bool
     */
    private function googleAccountAlreadyConnected($googleUser): bool
    {
        $existingUser = User::where('google_id', $googleUser->getId())->first();

        if ($existingUser) {
            return true;
        }
        return false;
    }


}
