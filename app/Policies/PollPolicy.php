<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PollPolicy
{

    // Kontrola zda je uživatel vlastník ankety
    public function isOwner(?User $user, Poll $poll): bool
    {
        return $user && $poll->user_id === $user->id;
    }

    // Kontrola zda má uživatel platný klíč správce
    public function hasValidKey(?User $user, Poll $poll): bool
    {
        return (session()->get('poll_admin_keys.' . $poll->id, null) === $poll->admin_key);
    }

    // Kontrola zda je uživatel správce ankety
    public function isAdmin(?User $user, Poll $poll): bool
    {
        return $this->hasValidKey($user, $poll) || $this->isOwner($user, $poll);
    }

    // Kontrola zda je uživatel správce ankety
    public function hasAdminPermissions(?User $user, Poll $poll): bool
    {
        return $this->hasValidKey($user, $poll) || $this->isOwner($user, $poll);
    }

    // Kontrola zda má uživatel platnou pozvánku
    public function hasValidInvitation(?User $user, Poll $poll): bool
    {
        if ($this->hasAdminPermissions($user, $poll)) return true;
        if ($poll->settings['invite_only']) {
            return $this->invitationExist($poll);
        }

        return true;
    }

    // Kontrola zda existuje pozvánka
    private function invitationExist($poll)
    {
        $invitationKey = session()->get('poll_invitations.' . $poll->id, null);
        return $poll->invitations->where('key', $invitationKey)->isNotEmpty();
    }

    // Kontrola zda má uživatel platné heslo
    public function hasValidPassword(?User $user, Poll $poll): bool
    {
        if ($this->hasAdminPermissions($user, $poll)) return true;
        if ($this->invitationExist($poll)) return true;

        if ($poll->password !== null) {
            return session()->has('poll_passwords.' . $poll->id . '.expiration') && session()->get('poll_passwords.' . $poll->id . '.expiration') > now();
        }

        return true;
    }

    // Kontrola zda může uživatel hlasovat
    public function canVote(?User $user, Poll $poll): bool
    {
        if(!Auth::check()){
            if(session()->get('poll.' . $poll->id . '.vote')){
                return false;
            }
        }
        return $poll->isActive();

    }

    // Kontrola zda může uživatel přidat novou časovou možnost
    public function addOption(?User $user, Poll $poll): bool
    {
        if (!$poll->isActive()) {
            return false;
        }

        return $poll->settings['add_time_options'] || $this->isAdmin($user, $poll);
    }


    // Kontrola zda může uživatel uzavřít anketu
    public function close(?User $user, Poll $poll): bool
    {
        if ($poll->votes()->count() === 0) {
            return false;
        }

        if (!$this->isAdmin($user, $poll)) {
            return false;
        }

        if ($poll->isActive()) {
            return $poll->votes()->count() > 0;
        }

        return true;
    }


    // Kontrola zda může uživatel upravit anketu
    public function edit(?User $user, Poll $poll): bool
    {
        if (!$poll->isActive()) {
            return false;
        }

        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return $poll->user_id === $user->id;
    }

    // Kontrola zda může uživatel odeslat pozvánku
    public function invite(User $user, Poll $poll): bool
    {
        if(!$poll->isActive()) {
            return false;
        }

        if ($this->hasAdminPermissions($user, $poll)) {
            return true;
        }

        return false;
    }


    // Kontrola zda může uživatel vytvořit událost
    public function createEvent(?User $user, Poll $poll): bool
    {
        if ($poll->isActive()) {
            return false;
        }

        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return false;
    }

    // Kontrola zda může uživatel vybrat konečné výsledky
    public function chooseResults(?User $user, Poll $poll): bool
    {
        if($poll->event !== null) {
            return false;
        }

        if($poll->isActive()) {
            return false;
        }

        if ($this->hasAdminPermissions($user, $poll)) {
            return true;
        }

        return false;
    }

    // Kontrola zda může uživatel zobrazit výsledky
    public function viewResults(?User $user, Poll $poll): bool
    {
        if ($this->hasAdminPermissions($user, $poll)) {
            return true;
        }

        return !$poll->settings['hide_results'];
    }

    // Kontrola zda může uživatel přidat novou možnost
    public function addNewOption(?User $user, Poll $poll): bool
    {
        if(!$poll->isActive()) {
            return false;
        }

        if ($this->hasAdminPermissions($user, $poll)) {
            return true;
        }

        if($poll->settings['add_time_options']) {
            return true;
        }

        return false;
    }

}
