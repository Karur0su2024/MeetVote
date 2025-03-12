<!DOCTYPE html>
<html>
<head>
    <title>Poll created</title>
</head>
<body>
    <p>Your created new poll.</p>
    <p>Poll link: {{ route('polls.show', $poll->public_id) }}</p>
    <p>Admin link: {{ route('polls.show.admin', ['poll' => $poll->public_id, 'admin_key' => $poll->admin_key]) }}</p>
</body>
</html>
