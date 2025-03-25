<?php

namespace App\Services;

use App\Models\SyncedEvent;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google_Client;
use Google_Service_Calendar_Event;

class GoogleService
{
    protected GoogleCalendarService $service;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }


    /**
     * @return GoogleCalendarService
     */
    public function getGoogleCalendarService(): GoogleCalendarService
    {
        return $this->googleCalendarService;
    }




}
