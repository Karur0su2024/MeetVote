<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // Obnovení zapomenutého hesla
//    public function resetPassword()
//    {
//        $token = request()->query('token');
//        $email = request()->query('email');
//
//        return view('pages.auth.reset-password', [
//            'token' => $token,
//            'email' => $email,
//        ]);
//    }

    // Odhlášení uživatele
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
