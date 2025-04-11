<?php

namespace App\Services\Google;


use App\Interfaces\GoogleServiceInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

/**
 *
 */
class GoogleService implements GoogleServiceInterface
{

    /**
     * Přesměruje uživatele na Google pro přihlášení
     * @return mixed
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')
            ->scopes(config('google.oauth_scopes'))->with(['access_type' => 'offline', 'prompt' => 'consent']) ->redirect();
    }


    /**
     * Zpracuje požadavek Google po přihlášení
     * @param GoogleUser $googleUser
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object|null
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect(route('home'));
        }

        $user = $this->googleAccountAlreadyConnected($googleUser);

        if($user){
            if(Auth::check()){
                return redirect(route('settings'))->with('error', 'Google account is already connected to another user.');
            }
            Auth::login($user, true);
            return redirect(route('dashboard'))->with('success', 'You were successfully logged in!');
        }


        if(Auth::check()){
            $user = Auth::user();
            $user->update($this->buildGoogleUser($googleUser));
            return redirect(route('settings'))->with('success', 'Google account connected successfully.');
        } else {
            $user = $this->checkIfEmailExists($googleUser->getEmail());
            if($user){
                $user->update($this->buildGoogleUser($googleUser));
            }
            else {
                $user = User::create($this->buildGoogleUser($googleUser));
                event(new Registered($user));
            }
            Auth::login($user, true);
        }


        return redirect(route('home'));
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
    private function googleAccountAlreadyConnected($googleUser): ?User
    {
        return User::where('google_id', $googleUser->getId())->first();
    }

    private function checkIfEmailExists($email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function disconnectFromGoogle()
    {
        $user = Auth::user();
        $user->google_id = null;
        $user->google_token = null;
        $user->google_refresh_token = null;
        $user->google_avatar = null;
        $user->save();

        return redirect(route('settings'))->with('success', 'Google account disconnected successfully.');
    }


    public function syncWithGoogleCalendar($users, $event)
    {

        $googleCalendarService = new GoogleCalendarService();
        app()->instance(GoogleCalendarService::class, $googleCalendarService);

        $event->load('syncedEvents');

        try {
            $googleEvent = $googleCalendarService->buildGoogleEvent($event);

            foreach($users as $user){
                if(!$user->google_id){
                    continue;
                }
                $googleCalendarService->checkToken($user);
                $googleCalendarService->desyncEvent($event, $user->id);

                $googleCalendarService->syncEvent($googleEvent, $event, $user);
            }
        }
        catch (\Exception $exception){
            // Špatný json
            // TODO: přidat logování
        }

    }

    public function desyncWithGoogleCalendar($event)
    {

        try {
            $googleCalendarService = new GoogleCalendarService();

            $syncedEvents = $event->syncedEvents;

            foreach($syncedEvents as $syncedEvent){
                $googleCalendarService->checkToken($syncedEvent->user);
                $googleCalendarService->desyncEvent($syncedEvent->event, $syncedEvent->user->id);
            }

        } catch (\Exception $e) {
            // Přidat logování (v budoucnu)
        }

    }

    public function checkAvailability($user, $option)
    {
        try {
            $startTime = $option['date'] . ' ' . ($option['content']['start'] ?? '');
            $endTime = $option['date'] . ' ' . ($option['content']['end'] ?? '');

            $googleCalendarService = new GoogleCalendarService();
            $googleCalendarService->checkToken($user);

            $start = date('c', strtotime($startTime));
            $end = date('c', strtotime($endTime));

            $events = $googleCalendarService->getEvents($start, $end) ?? [];

            return count($events) === 0;
        } catch (\Exception $e) {
            // Logování chyby
            return null; // V případě chyby vrátíme null (neznámý stav)
        }

    }
}
