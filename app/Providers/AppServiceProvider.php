<?php

namespace App\Providers;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
