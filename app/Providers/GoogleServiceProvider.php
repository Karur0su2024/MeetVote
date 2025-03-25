<?php

namespace App\Providers;

use App\Interfaces\GoogleServiceInterface;
use App\Services\Google\GoogleService;
use App\Services\Google\GoogleServiceEmpty;
use App\Services\GoogleCalendarService;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if($this->isConfigured()){
            $this->app->singleton(GoogleServiceInterface::class, function ($app) {
                return new GoogleService(
                    $app->make(GoogleCalendarService::class),
                );
            });
        }
        else {
            $this->app->singleton(GoogleServiceInterface::class, function ($app) {
                return new GoogleServiceEmpty();
            });
        }

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }

    private function isConfigured(): bool
    {
        return config('google.service_enabled');
    }
}
