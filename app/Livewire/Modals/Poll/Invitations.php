<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Invitation;
use App\Models\Poll;
use App\Services\EmailService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class Invitations extends Component
{
    /**
     * @var
     */
    public $poll;

    /**
     * @var array
     */
    public $invitations = [];

    /**
     * @var
     */
    public $email;

    /**
     * @var EmailService|\Illuminate\Foundation\Application|mixed|object|\Spatie\Ignition\Config\FileConfigManager
     */
    protected EmailService $notificationService;

    /**
     * @var string[]
     */
    protected $rules = [
        'email' => 'required|email',
    ];


    // Konstruktor

    /**
     *
     */
    public function boot(EmailService $notificationService): void
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @param $pollId
     * @return void
     */
    public function mount($pollIndex): void
    {
        $this->poll = Poll::with('invitations')->find($pollIndex);
        $this->loadInvitations();
    }

    // Metoda pro načtení pozvánek

    /**
     * @return void
     */
    private function loadInvitations()
    {
        $this->invitations = [];

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

    /**
     * @return void
     */
    public function addInvitation()
    {
        if(!$this->poll->isActive()) {
            $this->addError('error', __('ui/modals.invitations.message.error.closed'));
            return;
        }

        if(Gate::allows('invitate', $this->poll)) {
            $this->addError('error', __('ui/modals.invitations.message.error.no_permissions'));
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
        $this->poll->refresh();
        $this->loadInvitations();

    }

    // Metoda pro odebrání pozvánky

    /**
     * @param $id
     * @return void
     */
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

    /**
     * @param $id
     * @return void
     */
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


    /**
     * Kontrola, zda lze pozvánku odeslat
     * @return bool
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.modals.poll.invitations');
    }
}
