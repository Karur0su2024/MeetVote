<?php

namespace App\Providers;

use App\Services\Google\GoogleAuthService;
use App\Services\Google\GoogleAuthServiceEmpty;
use App\Services\Google\GoogleService;
use App\Services\Google\GoogleServiceEmpty;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Google\GoogleAuthServiceInterface;
use App\Interfaces\GoogleServiceInterface;

class GoogleServiceProvider extends ServiceProvider
{
    // Pokud je Google povoleno, použije se GoogleService
    // Jinak se použije GoogleServiceEmpty, který neprovádí žádné akce
    public function register(): void
    {
        if($this->isConfigured()){
            $this->app->singleton(GoogleAuthServiceInterface::class, function ($app) {
                return new GoogleAuthService();
            });
            $this->app->singleton(GoogleServiceInterface::class, function ($app) {
                return new GoogleService();
            });
        }
        else {
            $this->app->singleton(GoogleAuthServiceInterface::class, function ($app) {
                return new GoogleAuthServiceEmpty();
            });
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
