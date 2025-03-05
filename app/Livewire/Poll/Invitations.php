<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Str;

class Invitations extends Component
{
    public $poll;
    public $invitations = [];
    public $email;

    public function mount($poll)
    {
        $this->poll = $poll;
        $this->loadInvitations();
    }

    private function loadInvitations(){
        $this->invitations = [];
        foreach($this->poll->invitations as $invitation) {
            $this->invitations[] = [
                'id' => $invitation->id,
                'email' => $invitation->email,
                'status' => $invitation->status,
                'key' => $invitation->key,
                'sent_at' => $invitation->sent_at,
            ];
        }
    }


    public function addInvitation()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        foreach($this->poll->invitations as $invitation) {
            if($invitation->email === $this->email) {
                //Vypsat error
                return;
            }
        }

        $invitation = new Invitation();
        $invitation->poll_id = $this->poll->id;
        $invitation->email = $this->email;
        $invitation->status = 'pending';
        $invitation->key = Str::random(40);
        $invitation->save();

        // Odeslat email
        // Později přidat

        $this->loadInvitations();
        $this->email = '';
    }

    public function removeInvitation($id)
    {
        $invitation = Invitation::find($id);
        $invitation->delete();

        $this->loadInvitations();
    }

    public function render()
    {
        return view('livewire.poll.invitations');
    }
}
