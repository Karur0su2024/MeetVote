<?php

namespace App\Providers;

use App\Events\InvitationSent;
use App\Events\PollCreated;
use App\Events\VoteSubmitted;
use App\Interfaces\EmailServiceInterface;
use App\Listeners\SendInvitationEmail;
use App\Listeners\SendPollConfirmationEmail;
use App\Listeners\SendVoteNotificationEmail;
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

    /**
     * Bootstrap services.
     */
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

    }

}
