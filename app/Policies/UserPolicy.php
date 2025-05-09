<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Kontrola zda má uživatel připojený Google Kalendář
    public function sync(User $user){
        if (config('google.service_enabled')) {
            if($user->calendar_access) {
                return true;
            }
        }


        return false;
    }
}
