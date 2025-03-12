<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoteNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $poll;
    public $vote;

    /**
     * Create a new message instance.
     */
    public function __construct($poll, $vote)
    {
        $this->poll = $poll;
        $this->vote = $vote;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your poll ' . $this->poll->title . ' has received a new response',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.polls.vote-notification',
            with: [
                'poll' => $this->poll,
                'vote' => $this->vote,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
