<?php

namespace App\Providers;

use App\Events\PollCreated;
use App\Events\PollEventCreated;
use App\Events\PollReopened;
use App\Events\VoteSubmitted;
use App\Events\PollEventDeleted;
use App\Listeners\DesyncCalendarEvent;
use App\Listeners\SendPollConfirmationEmail;
use App\Listeners\SendVoteNotificationEmail;
use App\Listeners\SyncWithGoogleCalendar;
use App\Models\Poll;
use App\Policies\PollPolicy;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use App\Services\PollService;
use App\Services\QuestionService;
use App\Services\TimeOptionService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('App\Services\PollService', function ($app) {
            return new \App\Services\PollService(
                $app->make('App\Services\TimeOptionService'),
                $app->make('App\Services\QuestionService')
            );
        });
        $this->app->singleton('App\Services\TimeOptionService', function ($app) {
            return new \App\Services\TimeOptionService;
        });
        $this->app->singleton('App\Services\QuestionService', function ($app) {
            return new \App\Services\QuestionService;
        });


        $this->app->singleton('App\Services\VoteService', function ($app) {
            return new \App\Services\VoteService(
                $app->make('App\Services\TimeOptionService'),
                $app->make('App\Services\QuestionService')
            );
        });

        $this->app->singleton('App\Services\EventService', function ($app) {
            return new \App\Services\EventService;
        });

        $this->app->singleton('App\Services\InvitationService', function ($app) {
            return new \App\Services\InvitationService;
        });

        $this->app->singleton('App\Services\PollResultsService', function ($app) {
            return new \App\Services\PollResultsService(
                $app->make(PollService::class),
            );
        });

        $this->app->singleton('App\Services\PollQueryService', function ($app) {
            return new \App\Services\PollQueryService;
        });

        $this->app->singleton('App\Services\PollCreateService', function ($app) {
            return new PollCreateService(
                $app->make(TimeOptionService::class),
                $app->make(TimeOptionService::class),
            );
        });

        $this->app->singleton('App\Services\Poll\PollQueryService', function ($app) {
            return new PollQueryService(
                $app->make(TimeOptionService::class),
                $app->make(QuestionService::class),
            );
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

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
