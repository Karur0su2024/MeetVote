<?php

use App\Providers\AppServiceProvider;
use App\Providers\EmailServiceProvider;
use App\Providers\GoogleServiceProvider;
use App\Providers\VoltServiceProvider;

return [
    AppServiceProvider::class,
    EmailServiceProvider::class,
    GoogleServiceProvider::class,
    VoltServiceProvider::class,
];
