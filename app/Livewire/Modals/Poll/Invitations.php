<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Invitation;
use App\Models\Poll;
use App\Services\NotificationService;
use Illuminate\Support\Str;
use Livewire\Component;

class Invitations extends Component
{
    public $poll;

    public $invitations = [];

    public $email;

    protected NotificationService $notificationService;

    protected $rules = [
        'email' => 'required|email',
    ];

    // Konstruktor
    public function __construct()
    {
        $this->notificationService = app(NotificationService::class);
    }

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();
        $this->loadInvitations();
    }

    // Metoda pro načtení pozvánek
    private function loadInvitations()
    {
        $this->invitations = [];
        $this->poll->load('invitations');

        foreach ($this->poll->invitations as $invitation) {
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

        foreach ($this->poll->invitations as $invitation) {
            if ($invitation->email === $this->email) {
                // Vypsat error
                return;
            }
        }

        $invitation = Invitation::create([
            'poll_id' => $this->poll->id,
            'email' => $this->email,
            'status' => 'pending',
            'key' => Str::random(40),
        ]);

        // Odeslání pozvánky
        $this->notificationService->sendInvitation($this->email, $this->poll, $invitation->key);


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
        return view('livewire.modals.poll.invitations');
    }
}
