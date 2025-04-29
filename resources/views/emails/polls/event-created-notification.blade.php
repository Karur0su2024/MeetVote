<!DOCTYPE html>
<html>
<head>
    <title>Poll where you voted finalized results.</title>
</head>
<body>
<p>New event has been created.</p>
<h4>Event details:</h4>

<p>Event name: {{ $event->title }}</p>
<p>Event date and time: {{ Carbon\Carbon::parse($event->start_time)->format('d. m. Y H:i') }}
    - {{ Carbon\Carbon::parse($event->end_time)->format('H:i') }}</p>
<p>Event description: {{ $event->description }}</p>

<div>
    <a href="{{ $googleCalendarLink }}">Add to Google Calendar</a>
</div>
</body>
</html>
