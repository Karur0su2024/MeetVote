<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;
use App\Mail\InvitationEmail;
use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\RegistrationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService implements EmailServiceInterface
{

    // Potvrzení vytvoření ankety
    public function sendConfirmationEmail($poll): void
    {
        try {
            Log::info('Attempting to send confirmation email');
            Mail::to($poll->author_email)->send(new PollCreatedConfirmationEmail($poll));
            Log::info('Confirmation email sent successfully');
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }
    }

    public function sendVoteNotificationEmail($poll, $vote): void
    {
        try {
            Log::info('Attempting to send vote notification email');
            Mail::to($poll->author_email)->send(new VoteNotificationEmail($poll, $vote));
            Log::info('Vote notification email sent successfully');
        } catch (\Exception $e) {
            Log::error('Failed to send vote notification email: ' . $e->getMessage());
        }
    }

    public function sendInvitation($email, $poll, $key): void
    {
        try {
            Log::info('Attempting to send invitation email');
            Mail::to($email)->send(new InvitationEmail($poll, $key));
        } catch (\Exception $e) {
            Log::error('Failed to send invitation email: ' . $e->getMessage());
        }
    }

    public function sendRegistrationMail($user): void
    {
        try {
            Log::info('Attempting to send registration email');
            Mail::to($user->email)->send(new RegistrationEmail($user));
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
        }
    }

}
