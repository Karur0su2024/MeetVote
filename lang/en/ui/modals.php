<?php

return [
    'share' => [
        'title' => 'Share the poll',
        'labels' => [
            'link' => 'Link',
            'admin_link' => 'Admin link',
        ],
        'text' => [
            'link' => 'Share this link with participants so they can vote in the poll.',
            'admin_link' => 'This link is for administrators. It allows managing the poll and finalizing
                    results',
            'text_copied' => 'Link copied!',
        ],
        'button' => [
            'copy' => 'Copy',
            'copied' => 'Copied',
        ]
    ],
    'add_new_time_option' => [
        'title' => 'Add new time option to :poll_title',
        'buttons' => [
            'time_option' => 'Time option',
            'text_option' => 'Text option',
            'add_option' => 'Add option',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select date',
        ],
        'start_time' => [
            'label' => 'Start time',
            'placeholder' => 'Select start time',
        ],
        'end_time' => [
            'label' => 'End time',
            'placeholder' => 'Select end time',
        ],
        'text' => [
            'label' => 'Text',
            'placeholder' => 'Enter text option',
        ],
        'loading' => 'Adding...',
    ],
    'results' => [
        'title' => 'Poll results',
        'alert' => [
            'no_votes' => 'No votes yet.',
            'anonymous_votes' => 'Votes are anonymous. You can only see your own votes.',
        ],
        'buttons' => [
            'delete_vote' => 'Delete vote',
            'load_vote' => 'Load vote',
        ],
        'messages' => [
            'error' => [
                'delete' => 'You can\'t delete this vote.',
                'load' => 'You can\'t load this vote.',
            ],
        ],
    ],
    'create_event' => [
        'buttons' => [
            'import_from_results' => 'Import from poll results',
            'delete_event' => 'Delete event',
            'create_event' => 'Create event',
            'update_event' => 'Update event',
        ],
        'title' => 'Create event for poll :poll_title',
        'description' => 'Fill in the details below to create an event and optionally import final options from the poll results.',
        'event_title' => [
            'label' => 'Event title',
            'placeholder' => 'Enter event title',
        ],
        'start_time' => [
            'label' => 'Start',
            'placeholder' => 'Select start time of event',
        ],
        'end_time' => [
            'label' => 'End',
            'placeholder' => 'Select end time of event',
        ],
        'event_description' => [
            'label' => 'Event Description',
            'placeholder' => 'Enter event description...',
        ],
    ],
    'invitations' => [
        'title' => 'Invite participants',
        'text' => 'Send new invitation',
        'email' => [
            'label' => 'E-mail',
        ],
        'table' => [
            'headers' => [
                'email' => 'E-mail',
                'status' => 'Status',
                'sent_at' => 'Sent at',
                'actions' => 'Actions',
            ],
            'status' => [
                'pending' => 'Pending',
                'sent' => 'Sent',
                'failed' => 'Failed',
            ],
            'actions' => [
                'resend' => 'Resend',
                'delete' => 'Delete',
            ],
        ],
        'buttons' => [
            'send' => 'Send invitation',
        ],
        'loading' => 'Sending...',
        'message' => [
            'success' => 'Invitation sent successfully.',
            'error' => 'An error occurred while sending the invitation.',
        ],
        'alerts' => [
            'error' => [
                'closed' => 'This poll is closed. You can\'t send invitations.',
            ],
        ],
    ],
    'close_poll' => [
        'title' => [
            'close' => 'Close poll',
            'reopen' => 'Reopen poll',
        ],
        'text' => [
            'reopen' => 'Do you want to reopen this poll? Users will be able to vote again.',
            'poll_count' => 'This poll has :count_poll_votes votes. Closing the poll will prevent any further
                        voting.',
            'is_user_sure' => 'Are you sure you want to close this poll? Once closed, no further votes will be accepted.',
        ],
        'buttons' => [
            'close' => 'Close poll',
            'reopen' => 'Reopen poll',
            'cancel' => 'Cancel',
        ],
        'alerts' => [
            'no_votes' =>   'This poll has no votes.
                            Poll can be closed only if
                            there is at least one vote.',
            'event_will_be_deleted' => 'Warning: If you created event, it will be
                    deleted.'
        ],
        'messages' => [
            'success' => [],
            'error' => [],
        ],

    ],
    'choose_final_options' => [
        'title' => 'Close Poll',
        'description' => 'Best options are already selected. You can choose different options if you want.
                          These will be inserted to form for creating event.',
        'accordion' => [
            'poll_options' => 'Poll options',
            'table_headers' => [
                'option' => 'Option',
                'score' => 'Score',
                'select' => 'Select',
            ],
        ],
        'buttons' => [
            'insert_to_calendar' => 'Insert to Calendar',
        ],
    ],
    'error' => [
        'title' => 'Error',
        'text' => 'An error occurred while processing your request. Please try again later.',
    ],
];

