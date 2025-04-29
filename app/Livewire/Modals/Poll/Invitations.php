<?php

namespace App\Livewire\Modals\Poll;

use App\Events\InvitationSent;
use App\Models\Invitation;
use App\Models\Poll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

/**
 *
 */
class Invitations extends Component
{
    public $poll;
    public $emails;

    public function mount($pollIndex): void
    {
        $this->poll = Poll::find($pollIndex);
        $this->poll->load('invitations');
    }

    public function addInvitations()
    {
        if(Gate::denies('invite', $this->poll)) {
            $this->addError('error', __('ui/modals.invitations.message.error.no_permissions'));
            return;
        }

        $validEmails = $this->processEmails(preg_split('/[,;\n]/', $this->emails, -1, PREG_SPLIT_NO_EMPTY));

        $invitations = $this->poll->invitations()->createMany($validEmails);

        InvitationSent::dispatch($invitations);

        $this->poll->refresh();
    }

    private function processEmails($emailArray){
        $invalidEmails = [];
        $validEmails = [];

        foreach($emailArray as $email) {
            $email = trim($email);

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $invalidEmails[] = $email;
                $this->addError('error', 'Some emails you entered are invalid');
                continue;
            }

            if ($this->poll->invitations()->where('email', $email)->exists()) {
                continue;
            }

            $validEmails[] = ['email' => $email];
        }

        $this->emails = implode(',', $invalidEmails);
        return $validEmails;
    }

    public function removeInvitation($id)
    {
        $invitation = Invitation::find($id);

        if ($invitation) {
            $invitation->delete();
            session()->flash('success', 'Invitation deleted successfully.');
        } else {
            session()->flash('error', 'Invitation not found.');
        }

        $this->poll->refresh();
    }

    /**
     * @param $id
     * @return void
     */
    public function resendInvitation($id)
    {

        $invitation = Invitation::where('id', $id)->get();

        if ($invitation) {
            InvitationSent::dispatch($invitation);
            session()->flash('success', 'Invitation resent successfully.');
        } else {
            session()->flash('error', 'Invitation not found.');
        }
    }


    public function render()
    {
        return view('livewire.modals.poll.invitations');
    }
}
