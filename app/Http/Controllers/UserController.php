<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('pages.user.dashboard');
    }

    public function settings()
    {
        return view('pages.user.settings');
    }

    public function resetPassword()
    {
        $token = request()->query('token');
        $email = request()->query('email');

        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
