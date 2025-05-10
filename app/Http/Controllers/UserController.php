<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Stránka dashboardu se všemi anketami
    public function dashboard()
    {
        return view('pages.user.dashboard');
    }

    // Stránka s nastavením uživatele
    public function settings()
    {
        return view('pages.user.settings');
    }

    // Obnovení zapomenutého hesla
    public function resetPassword()
    {
        $token = request()->query('token');
        $email = request()->query('email');

        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    // Odhlášení uživatele
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
