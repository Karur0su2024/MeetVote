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
use App\Services\Question\QuestionCreateService;
use App\Services\Question\QuestionQueryService;
use App\Services\QuestionService;
use App\Services\TimeOptions\TimeOptionCreateService;
use App\Services\TimeOptions\TimeOptionQueryService;
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

        $this->app->singleton('App\Services\VoteService', function ($app) {
            return new \App\Services\VoteService(
                $app->make('App\Services\TimeOptionService'),
                $app->make('App\Services\QuestionService')
            );
        });

        $this->app->singleton('App\Services\PollResultsService', function ($app) {
            return new \App\Services\PollResultsService(
                $app->make(PollService::class),
            );
        });

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
