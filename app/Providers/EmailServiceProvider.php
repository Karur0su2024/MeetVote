<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmailServiceInterface;
use App\Services\EmailService;
use App\Services\EmailServiceEmpty;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if($this->isConfigured()){
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

    }

    public function isConfigured()
    {
        return config('mail.allowed');
    }

}
