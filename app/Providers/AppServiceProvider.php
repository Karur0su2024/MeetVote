<?php

namespace App\Providers;

use App\Events\PollEventCreated;
use App\Events\PollEventDeleted;
use App\Events\PollReopened;
use App\Listeners\AssignPollsToNewUser;
use App\Listeners\DesyncCalendarEvent;
use App\Listeners\SendRegistrationEmail;
use App\Listeners\SyncWithGoogleCalendar;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use App\Services\PollResultsService;
use App\Services\Question\QuestionCreateService;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionCreateService;
use App\Services\TimeOptions\TimeOptionQueryService;
use App\Services\Vote\VoteQueryService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    // Registrace do Service Containeru
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

        // Pokud se uživatel zaregistruje, odešle se mu registrační email
        Event::listen(
            Registered::class,
            SendRegistrationEmail::class,
        );

        // Pokud se uživatel zaregistruje, přiřadí se mu ankety a odpovědi se stejnou emailovou adresou
        Event::listen(
            Registered::class,
            AssignPollsToNewUser::class,
        );

        // Pokud se vytvoří nový událost, synchronizuje se s Google kalendářem
        Event::listen(
            PollEventCreated::class,
            SyncWithGoogleCalendar::class,
        );

        // Pokud se anketa znovu otevře, odstraní se předchozí synchronizace s Google kalendářem
        Event::listen(
          PollReopened::class,
          DesyncCalendarEvent::class,
        );

        // Pokud se událost odstraní, odstraní se synchronizace s Google kalendářem
        Event::listen(
            PollEventDeleted::class,
            DesyncCalendarEvent::class,
        );



    }
}
