<?php

namespace App\Providers;

use App\Events\InvitationSent;
use App\Events\PollCreated;
use App\Events\PollEventCreated;
use App\Events\VoteSubmitted;
use App\Interfaces\EmailServiceInterface;
use App\Listeners\SendEventEmails;
use App\Listeners\SendInvitationEmail;
use App\Listeners\SendPollConfirmationEmail;
use App\Listeners\SendVoteNotificationEmail;
use App\Listeners\SyncWithGoogleCalendar;
use App\Services\Mail\EmailService;
use App\Services\Mail\EmailServiceEmpty;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Pokud je odesílání emailů povoleno, použije se EmailService
        // Jinak se použije EmailServiceEmpty, který neprovádí žádné akce
        if(config('mail.allowed')){
            $this->app->singleton(EmailServiceInterface::class, function ($app) {
                return new EmailService();
            });
        }
        else {
            $this->app->singleton(EmailServiceInterface::class, function ($app) {
                return new EmailServiceEmpty();
            });
        }


    }

    // Registrace listenerů pro eventy, které odesílají emaily
    public function boot(): void
    {
        Event::listen(
            InvitationSent::class,
            SendInvitationEmail::class,
        );

        Event::listen(
            PollCreated::class,
            SendPollConfirmationEmail::class,
        );
        Event::listen(
            VoteSubmitted::class,
            SendVoteNotificationEmail::class,
        );
        Event::listen(
            PollEventCreated::class,
            SendEventEmails::class,
        );
    }

}
