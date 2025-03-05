<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    
    public function create()
    {
        return view('pages.polls.create');
    }

    public function show(Poll $poll)
    {
        return view('pages.polls.show', ['poll' => $poll]);
    }

    public function edit(Poll $poll)
    {
        return view('pages.polls.edit', ['poll' => $poll]);
    }

    public function authentification(Poll $poll)
    {
        return view('pages.polls.authentification', ['poll' => $poll]);
    }

    public function checkPassword(Request $request, Poll $poll)
    {
        if($request->password === $poll->password) {
            //return dd('OK');
            session()->put('poll_' . $poll->public_id . '_password', $request->password);
            return redirect()->route('polls.show', $poll);
        }

        return dd('KO');
        return redirect()->back()->with('error', 'Špatné heslo');
    }

}
