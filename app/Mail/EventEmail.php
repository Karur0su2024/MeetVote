<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Event;
use Spatie\CalendarLinks\Link;
use DateTime;

class EventEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $poll;
    public $calendarLink;
    public $googleCalendarLink;


    /**
     * Create a new message instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->calendarLink = $this->buildLink();
        $this->googleCalendarLink = $this->calendarLink->google();
    }

    private function buildLink()
    {
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['start_time']);
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['end_time']);
        return Link::create($this->event['title'], $from, $to)->description($this->event['description']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event has been chosen',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.polls.event-created-notification',
            with: [
                'event' => $this->event,
                'googleCalendarLink' => $this->googleCalendarLink,
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
        return [
            Attachment::fromData(fn () => $this->calendarLink->ics(), 'event.ics')
                ->withMime('text/calendar'),
        ];
    }
}
