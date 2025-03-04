<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $userPolls = Auth::user()->polls;
        $attendeePolls = Auth::user()->attendeePolls;
        $polls = $userPolls->merge($attendeePolls);
        return view('pages.user.dashboard', ['polls' => $polls]);
    }

    public function settings()
    {
        return view('pages.user.settings');
    }
}
