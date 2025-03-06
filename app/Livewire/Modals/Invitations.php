<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Models\Poll;

class Invitations extends Component
{

    public $poll;
    public $invitations = [];
    public $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();
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

        $this->validate();

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
        return view('livewire.modals.invitations');
    }
}
