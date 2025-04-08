<?php

namespace App\Providers;

use App\Events\InvitationSent;
use App\Events\PollCreated;
use App\Events\PollEventCreated;
use App\Events\PollEventDeleted;
use App\Events\PollReopened;
use App\Events\VoteSubmitted;
use App\Listeners\DesyncCalendarEvent;
use App\Listeners\SendInvitationEmail;
use App\Listeners\SendPollConfirmationEmail;
use App\Listeners\SendVoteNotificationEmail;
use App\Listeners\SyncWithGoogleCalendar;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use App\Services\PollResultsService;
use App\Services\Question\QuestionCreateService;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionCreateService;
use App\Services\TimeOptions\TimeOptionQueryService;
use App\Services\Vote\VoteQueryService;
use App\Services\Vote\VoteService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PollCreateService::class, function ($app) {
            return new PollCreateService(
                $app->make(TimeOptionCreateService::class),
                $app->make(QuestionCreateService::class),
            );
        });

        $this->app->singleton(PollQueryService::class, function ($app) {
            return new PollQueryService(
                $app->make(TimeOptionQueryService::class),
                $app->make(QuestionQueryService::class),
            );
        });

        $this->app->singleton(VoteQueryService::class, function ($app) {
            return new VoteQueryService(
                $app->make(TimeOptionQueryService::class),
                $app->make(QuestionQueryService::class),
            );
        });

        $this->app->singleton(PollResultsService::class, function ($app) {
            return new PollResultsService(
                $app->make(TimeOptionQueryService::class),
                $app->make(QuestionQueryService::class),
            );
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Event::listen(
            PollEventCreated::class,
            SyncWithGoogleCalendar::class,
        );

        Event::listen(
          PollReopened::class,
          DesyncCalendarEvent::class,
        );

        Event::listen(
            PollEventDeleted::class,
            DesyncCalendarEvent::class,
        );



    }
}
