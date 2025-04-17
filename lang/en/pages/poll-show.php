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
            'attributes' => [
                'anonymous_votes' => 'Votes are anonymous',
                'comments' => 'Comments allowed',
                'invite_only' => 'Invite only',
                'hide_results' => 'Hidden results',
                'password_protected' => 'Password protected',
                'add_time_options' => 'Voters can add time options',
            ],
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
        'description' => 'Vote for the time that suits you best for meeting. Click on the options to change preference.',
        'sections' => [
            'time_options' => [
                'title' => 'Time options',
                'tooltip' => 'Choose the time that suits you best for meeting.',
            ],
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
            'notes' => [
                'label' => 'Additional notes',
                'placeholder' => 'Your additional notes to poll...',
            ],
            'loading' => 'Submitting...',
        ],
        'buttons' => [
            'add_time_option' => 'Add new time option',
            'results' => 'Results',
            'submit_vote' => 'Submit vote',
            'check_availability' => [
                'label' => 'Check calendar availability',
                'tooltip' => 'Check for your Google Calendar availability',
                'loading' => 'Checking availability...',
            ],
            'show_result_section' => [
                'label' => 'Show results',
            ],
        ],
        'alert' => [
            'poll_closed' => 'Poll is closed. You can no longer vote.',
        ],
    ],
    'results' => [
        'title' => 'Results',
        'description' => 'You can see the results of the poll here.',
        'sections' => [
            'all_votes' => [
                'title' => 'All votes',
                'empty' => 'No votes yet.',
                'anonymous' => 'Anonymous',
            ],
            'results' => [
                'view_only' => [
                    'title' => 'Results',
                    'section' => [
                        'time_options' => 'Time options',
                    ],
                ],
                'pick_from_results' => [
                    'title' => 'Choose final results',
                    'description' => 'Pick options you want to use for event creation.
                                        Event represent final results of the poll.',
                    'section' => [
                        'time_options' => 'Time options',
                    ],
                    'buttons' => [
                        'create_event' => [
                            'label' => 'Create event',
                            'tooltip' => 'Open event creation modal and pre-fill it with picked results.
                                            Then you can share the event with your friends.',
                        ],
                    ],
                ],
                'buttons' => [
                    'show_voting_section' => 'Show voting options',
                ],
            ],
        ],
        'alerts' => [
            'hidden' => 'Poll results are hidden by the poll creator.',
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
    'your_vote' => [
        'title' => 'Your vote',
        'no_vote' => 'You have not voted yet.',
        'buttons' => [
            'delete' => 'Delete vote',
        ],
    ],
];

