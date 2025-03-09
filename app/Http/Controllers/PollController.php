<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

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
        if ($request->password === $poll->password) {
            // return dd('OK');
            session()->put('poll_'.$poll->public_id.'_password', $request->password);

            return redirect()->route('polls.show', $poll);
        }

        return redirect()->back()->with('error', 'Špatné heslo');
    }

    public function addAdmin(Poll $poll, $admin_key)
    {
        if ($admin_key !== $poll->admin_key) {
            // return redirect()->back()->with('error', 'Špatný klíč správce ankety');
        }

        session()->put('poll_'.$poll->public_id.'_adminKey', $admin_key);

        return redirect()->route('polls.show', $poll);
    }
}
