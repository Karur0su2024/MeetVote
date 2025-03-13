<!DOCTYPE html>
<html>

<head>
    <title>You have been+ invited to poll</title>
</head>

<body>
    <p>You have been invited to participate in a poll {{ $poll->title }}.</p>
    <p>Invitation link: {{ route('polls.invite', $key) }}</p>
</body>

</html>
