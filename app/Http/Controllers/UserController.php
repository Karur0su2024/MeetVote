<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $polls = Poll::where('user_id', Auth::id())->with('event')->get();

        $events = $polls->map(function ($poll) {
            return $poll->event;
        })->filter();

        $events->all();

        // dd($events);
        return view('pages.user.dashboard', compact('events'));
    }

    public function settings()
    {
        return view('pages.user.settings');
    }
}
