<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function sync(User $user){
        if($user->google_id){
            return true;
        }
        return false;
    }
}
