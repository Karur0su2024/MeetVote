<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Hash;


class PollController extends Controller
{
    public function create()
    {
        return view('pages.polls.create');
    }

    public function show(Poll $poll)
    {
        return view('pages.polls.show', compact('poll'));
    }

    public function edit(Poll $poll)
    {
        $pollIndex = $poll->id;
        $pollTitle = $poll->title;
        return view('pages.polls.edit', compact('pollIndex', 'pollTitle'));
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('dashboard')->with('success', 'Poll deleted successfully');
    }

    public function authentication(Poll $poll)
    {
        return view('pages.polls.authenticate', ['poll' => $poll]);
    }

    public function checkPassword(Request $request, Poll $poll)
    {
        if(Hash::check($request->password, $poll->password)) {
            session()->put('poll_'.$poll->public_id.'_password', $request->password);

            return redirect()->route('polls.show', $poll);
        }
        return redirect()->back()->with('error', 'Špatné heslo');
    }


    public function openPollWithInvitation($token)
    {
        $invitation = Invitation::where('key', $token)->firstOrFail();

        $poll = Poll::where('id', $invitation->poll_id)->firstOrFail();

        if($invitation->status === 'pending') {
            $invitation->status = 'active';
            $invitation->save();
        }

        session()->put('poll_'.$poll->public_id.'_invite', $token);

        return redirect()->route('polls.show', $poll);
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
