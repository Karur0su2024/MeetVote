<?php

namespace App\Interfaces;

interface GoogleServiceInterface
{
    public function syncWithGoogleCalendar($users, $eventData);

    public function desyncWithGoogleCalendar($event);

    public function checkAvailability($user, $timeOptions);

}
