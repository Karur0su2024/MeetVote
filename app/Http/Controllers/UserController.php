<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Poll;

class UserController extends Controller
{
    public function dashboard()
    {;
        $polls = Poll::where('user_id', Auth::id())->with('event')->get();



        $events = $polls->map(function ($poll){
            return $poll->event;
        })->filter();
        
        $events->all();

        //dd($events);
        return view('pages.user.dashboard', compact('events'));
    }

    public function settings()
    {
        return view('pages.user.settings');
    }
}
