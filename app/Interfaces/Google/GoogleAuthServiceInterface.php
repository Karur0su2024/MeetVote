<?php

namespace App\Interfaces\Google;

interface GoogleAuthServiceInterface
{

    public function redirectToGoogle();

    public function handleGoogleCallback();

    public function disconnectFromGoogle();
}
