<?php

namespace App\Listeners;

use App\Services\Mail\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvitationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(public EmailService $emailService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $invitation = $event->invitation;

        $this->emailService->sendInvitation($invitation->email, $invitation->poll, $invitation->key);
    }


}
