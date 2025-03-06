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

    protected $rules = [
        'email' => 'required|email|unique:invitations,email',
    ];

    public function mount($poll)
    {
        $this->poll = $poll;
        $this->loadInvitations();
    }


    // Metoda pro načtení pozvánek
    private function loadInvitations(){
        $this->invitations = [];
        $this->poll->load('invitations');

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


    // Metoda pro přidání pozvánky
    public function addInvitation()
    {

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

        $this->email = '';

        $this->loadInvitations();

    }


    // Metoda pro odebrání pozvánky 
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
