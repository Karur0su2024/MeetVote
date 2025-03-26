<?php

return [

    'settings' => [
        'dropdown' => [
            'options' => 'Options',
            'edit_poll' => 'Edit poll',
            'invitations' => 'Invitations',
            'share_poll' => 'Share poll',
            'close_poll' => 'Close poll',
            'reopen_poll' => 'Reopen poll',
            'delete_poll' => 'Delete poll',
        ],
    ],
    'info' => [
        'text' => [
            'no_description' => 'No description',
        ],
        'badges' => [
            'status' => [
                'active' => 'Active poll',
                'closed' => 'Closed poll',
            ],
            'comments' => 'Comments',
            'anonymous_voting' => 'Anonymous voting',
            'password_protected' => 'Password protected',
            'invite_only' => 'Invite only',
            'edit_votes' => 'Participants can edit their votes',
            'add_time_options' => 'Participants can add time options',
            'deadline_in' => 'Ends in:parse_poll_deadline days',
        ],
    ],
    'event_details' => [
        'title' => 'Event details',
        'dropdown' => [
            'header' => 'Import',
            'import_to_google' => 'Import to Google Calendar',
            'import_to_outlook' => 'Import to Outlook Calendar',
        ],
        'text' => [
            'synced_with_google' => 'Synced with Google Calendar',
            'start_time' => 'Start time:',
            'end_time' => 'End time:',
            'no_event_created_yet' => 'No event was created for this poll yet.',
            'poll_still_open' => 'Poll is still open.',
            'admin_can_create_event' => 'You can create an event only for closed.',
            'event_will_be_created' => 'Event will be created when the admin chooses the final options.',
        ],
        'buttons' => [
            'update_event' => 'Update event',
            'pick_from_results' => 'Manually',
            'automatically_create_event' => 'Automatically',
            'close_poll' => 'Close poll',
        ],
    ],
    'voting' => [
        'title' => 'Voting',
        'accordion' => [
          'time_options' => 'Time options',
        ],
        'form' => [
            'title' => 'Your information',
            'username' => [
                'label' => 'Username',
                'placeholder' => 'Enter your username',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter your email',
            ],
            'loading' => 'Submitting...',
        ],
        'buttons' => [
            'results' => 'Results',
            'submit_vote' => 'Submit vote',
        ],
        'alert' => [
            'poll_closed' => 'Poll is closed. You can no longer vote.',
        ],
    ],
    'comments' => [
    'title' => 'Comments',
    'form' => [
        'title' => 'Leave a comment',
        'username' => [
            'label' => 'Username',
            'placeholder' => 'Enter your username',
        ],
        'content' => [
            'label' => 'Comment',
            'placeholder' => 'Write a comment...',
        ],
        'loading' => 'Submitting...',
    ],
    'buttons' => [
        'submit' => 'Submit comment',
        'delete_comment' => 'Delete comment',
    ],

    'alert' => [
        'disabled' => 'CommentsSection are disabled for this poll.',
        'no_comments_yet' => 'No comments yet.',
    ],
],
];

