<!DOCTYPE html>
<html>

<head>
    <title>Poll created</title>
</head>

<body>
    <p>User {{ $vote->name ?? 'anonymous' }}has voted on your poll {{ $poll->title }}.</p>
    <p>Your poll has now {{ count($poll->votes) }} votes</p>
    <p>Poll link: {{ route('polls.show', $poll->public_id) }}</p>
</body>

</html>
