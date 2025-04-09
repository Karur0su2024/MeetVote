<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;
use App\Mail\InvitationEmail;
use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService implements EmailServiceInterface
{

    // Potvrzení vytvoření ankety
    public function sendConfirmationEmail($poll)
    {
        try {
            Log::info('Attempting to send confirmation email');
            Mail::to($poll->author_email)->send(new PollCreatedConfirmationEmail($poll));
            Log::info('Confirmation email sent successfully');
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation email');
        }
    }

    public function sendVoteNotificationEmail($poll, $vote)
    {
        try {
            Log::info('Attempting to send vote notification email');
            Mail::to($poll->author_email)->send(new VoteNotificationEmail($poll, $vote));
            Log::info('Vote notification email sent successfully');
        } catch (\Exception $e) {
            Log::error('Failed to send vote notification email');
        }
    }

    public function sendInvitation($email, $poll, $key)
    {
        try {
            Log::info('Attempting to send invitation email');
            Mail::to($email)->send(new InvitationEmail($poll, $key));
        } catch (\Exception $e) {
            Log::error('Failed to send invitation email', ['email' => $email, 'poll_id' => $poll->id, 'key' => $key]);
        }
    }

}
