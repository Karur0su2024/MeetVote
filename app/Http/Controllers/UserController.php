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
}
