<?php

namespace App\Listeners;

use App\Services\Mail\EmailService;

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
        $invitations = $event->invitations;

        foreach ($invitations as $invitation) {
            $this->emailService->sendInvitation($invitation->email, $invitation->poll, $invitation->key);
        }
    }
}
