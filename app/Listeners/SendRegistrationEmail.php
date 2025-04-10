<?php

namespace App\Listeners;

use App\Interfaces\EmailServiceInterface;
use App\Services\Mail\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(public EmailServiceInterface $emailService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        $this->emailService->sendRegistrationMail($user);

    }
}
