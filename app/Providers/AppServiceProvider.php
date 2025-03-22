<?php

namespace App\Providers;

use App\Events\PollCreated;
use App\Listeners\SendPollConfirmationEmail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

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

        //Sem doplnit další eventy
    }
}
