<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;


class PollController extends Controller
{
    // Zobrazení formuláře pro vytvoření ankety
    public function create()
    {
        return view('pages.polls.create');
    }

    // Zobrazeny stránky ankety
    public function show(Poll $poll)
    {
        if(session()->has('poll.' . $poll->id . '.vote')){
            $vote = Vote::find(session()->get('poll.' . $poll->id . '.vote'));
            if(!$vote) {
                session()->forget('poll.' . $poll->id . '.vote');
            }
        }


        return view('pages.polls.show', compact('poll'));
    }

    // Zobrazení formuláře pro úpravu ankety
    public function edit(Poll $poll)
    {
        $pollIndex = $poll->id;
        $publicId = $poll->public_id;
        $pollTitle = $poll->title;
        $pollDeadline = $poll->deadline;
        return view('pages.polls.edit', compact('pollIndex', 'pollTitle', 'publicId', 'pollDeadline'));
    }

    // Odstranění ankety
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('dashboard')->with('success', __('pages/dashboard.messages.success.poll_deleted'));
    }

    // Přesměrování na stránku pro ověření heslem
    public function authentication(Poll $poll)
    {
        return view('pages.polls.authenticate', ['poll' => $poll]);
    }

    // Ověření hesla
    public function checkPassword(Request $request, Poll $poll)
    {
        if(Hash::check($request->password, $poll->password)) {
            session()->put('poll_passwords.'.$poll->id . '.expiration', now()->addDays(config('poll.password_expiration_days')));
            return redirect()->route('polls.show', $poll);
        }
        return redirect()->back()->with('error', __('pages/poll-show.messages.errors.wrong_password'));
    }

    // Otevření ankety pomocí pozvánky
    public function openPollWithInvitation($token, InvitationService $invitationService)
    {
        $poll = $invitationService->checkInvitation($token);

        return redirect()->route('polls.show', $poll);
    }


    // Nastavení práva pro správce
    public function addAdmin(Poll $poll, $admin_key)
    {
        if ($admin_key !== $poll->admin_key) {
            return redirect()->route('polls.show', $poll)->with('error', __('pages/poll-show.messages.errors.wrong_admin_key'));
        }

        session()->forget('poll_admin_keys.'.$poll->id);
        session()->put('poll_admin_keys.'.$poll->id, $poll->admin_key);

        return redirect()->route('polls.show', $poll)->with('success', __('pages/poll-show.messages.success.admin_acquired'));
    }
}
