<?php

namespace App\Providers;

use App\Interfaces\GoogleServiceInterface;
use App\Services\GoogleCalendarService;
use App\Services\GoogleService;
use App\Services\GoogleServiceEmpty;
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
        // Sem přidat podmínku
        return false;
    }
}
