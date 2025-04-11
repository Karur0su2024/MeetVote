<?php

namespace App\Interfaces;

interface GoogleServiceInterface
{

    public function redirectToGoogle();


    public function handleGoogleCallback();

    public function disconnectFromGoogle();

    public function syncWithGoogleCalendar($users, $eventData);

    public function desyncWithGoogleCalendar($event);

    public function checkAvailability($user, $option);

}
