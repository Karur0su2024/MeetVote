<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Services\InvitationService;
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
        //dd(session()->get('poll_passwords'));
        return view('pages.polls.authenticate', ['poll' => $poll]);
    }

    public function checkPassword(Request $request, Poll $poll)
    {
        if(Hash::check($request->password, $poll->password)) {
            session()->forget('poll_passwords.'.$poll->id);
            session()->push('poll_passwords.'.$poll->id, $poll->password);
            return redirect()->route('polls.show', $poll);
        }
        return redirect()->back()->with('error', 'Wrong password');
    }


    public function openPollWithInvitation($token, InvitationService $invitationService)
    {
        $poll = $invitationService->checkInvitation($token);

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
