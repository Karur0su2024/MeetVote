<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Invitation;
use App\Models\Poll;
use App\Services\NotificationService;
use Illuminate\Support\Str;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        if (!$this->poll) {
            session()->flash('error', 'Poll not found.');
            return;
        }

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
                'sent_at' => Carbon::parse($invitation->sent_at)->diffForHumans(),
            ];
        }
    }

    // Metoda pro přidání pozvánky
    public function addInvitation()
    {
        // Kontrola, zda je uživatel přihlášen
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to send invitations.');
            return;
        }

        $this->validate();

        if($this->checkIfCanBeSent() === false) {
            return;
        }

        $invitation = Invitation::create([
            'poll_id' => $this->poll->id,
            'email' => $this->email,
            'status' => 'pending',
            'key' => Str::random(40),
            'sent_at' => now(),
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

        if ($invitation) {
            $invitation->delete();
            session()->flash('success', 'Invitation deleted successfully.');
        } else {
            session()->flash('error', 'Invitation not found.');
        }

        $this->loadInvitations();
    }

    public function resendInvitation($id)
    {
        if($this->checkIfCanBeSent() === false) {
            return;
        }

        $invitation = Invitation::find($id);


        if ($invitation) {
            $this->notificationService->sendInvitation($invitation->email, $this->poll, $invitation->key);
            session()->flash('success', 'Invitation resent successfully.');
        } else {
            session()->flash('error', 'Invitation not found.');
        }
    }


    private function checkIfCanBeSent(): bool
    {


        if(count($this->poll->invitations) >= 2) {
            session()->flash('error', 'You can only send 2 invitations to this poll.');
            return false;
        }


        $todayInvitations = $this->poll->invitations->where('sent_at', '>=', now()->subDay())->count();

        if ($todayInvitations >= 10) {
            session()->flash('error', 'You can only send 10 invitations per day.');
            return false;
        }

        foreach ($this->poll->invitations as $invitation) {
            if ($invitation->email === $this->email) {
                session()->flash('error', 'Invitation was already sent to this email.');
                return false;
            }
        }

        return true;
    }

    public function render()
    {
        return view('livewire.modals.poll.invitations');
    }
}
