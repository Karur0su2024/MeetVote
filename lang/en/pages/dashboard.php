<?php

return [
    'title' => 'Dashboard',
    'titles' => [
        'your_polls' => 'Your polls',
        'voted_polls' => 'Polls you voted in',
    ],
    'cards' => [
        'poll_count' => 'You have currently :polls_count polls.',
    ],
    'dropdowns' => [
        'filter' => [
            'title' => 'Filter',
            'items' => [
                'all' => 'All',
                'active' => 'Active',
                'closed' => 'Closed',
            ],
        ],
        'opened' => [
            'items' => [
                'polls' => 'Polls',
                'events' => 'Events',
            ],
        ]
    ],
    'buttons' => [
        'new_poll' => 'New poll',
    ],
    'alerts' => [
        'no_polls' => 'No polls found.',
        'no_events' => 'You don\'t have any events yet.',
        'no_connected_calendar' => [
            'text' => 'You can sync your events with Google Calendar. To do this, please link your Google account in the ',
            'link' => 'settings',
        ]
    ],

    'poll_card' => [
        'dropdown' => [
            'edit' => 'Edit',
            'share' => 'Share',
            'results' => 'Results',
            'delete' => 'Delete',
        ],
        'pills' => [
            'status' => [
                'active' => 'Active',
                'closed' => 'Closed',
            ],
            'admin' => 'Admin',
            'voted' => 'Voted',
        ],
        'stats' => [
            'votes' => 'Votes',
            'time_options' => 'Time options',
            'questions' => 'Questions',
        ],
        'buttons' => [
            'view' => 'View poll',
        ],
    ],

    'event_card' => [
        'buttons' => [
            'view' => "View event\'s poll",
        ],
    ],
];
