<?php

return [

    'page' => [
        'create' => 'Create a New Poll',
        'edit' => [
            'title' => 'Edit poll :poll_title',
        ],
    ],

    // Základní informace o anketě
    'basic_info' => [
        'title' => 'Poll information',

        'section' => [
            'poll' => 'Poll information',
            'user' => 'User information',
        ],

        'poll_title' => [
            'label' => 'Poll title',
            'placeholder' => 'Poll #1',
        ],
        'poll_description' => [
            'label' => 'Poll description',
            'placeholder' => 'Your poll description...',
        ],
        'poll_deadline' => [
            'label' => 'Deadline',
            'placeholder' => 'Enter the deadline for the poll',
            'tooltip' => 'Set the deadline for the poll. After this date, no new votes will be accepted. Deadline is not
                    required.',
        ],
        'poll_timezone' => [
            'label' => 'Timezone',
            'placeholder' => 'Select timezone',
            'tooltip' => 'Select the timezone for the poll. This will be used to display the poll times.',
        ],
        'user_name' => [
            'label' => 'Your name',
            'placeholder' => 'John Doe',
        ],
        'user_email' => [
            'label' => 'Your email',
            'placeholder' => 'adress@email.com',
        ],
    ],
    'time_options' => [
        'title' => 'Time options',
        'tooltip' => 'Select available dates and time slots for participants to vote on.',
        'calendar' => [
            'title' => 'Calendar',
            'dates' => 'Chosen dates',
        ],
        'label' => [
            'start' => 'Start time',
            'end' => 'End time',
        ],
        'button' => [
            'delete' => 'Delete date',
            'add_empty_time_option' => 'Add empty time option',
            'add_hour_time_option' => 'Add hour time option',
            'add_text_option' => 'Add text option',
        ],
        'error_messages' => [
            'empty_start' => 'Start of time option is required.',
            'empty_end' => 'End of time option is required.',
            'empty_text' => 'Text option is required.',
            'format_start' => 'Start of time option is in wrong format.',
            'format_end' => 'End of time option is in wrong format.',
            'after_start' => 'End of time option must be after start.',
        ],
    ],
    'questions' => [
        'title' => 'Additional questions',
        'tooltip' => 'Add additional questions to the poll. Questions are not required.',
        'alert' => [
            'no_questions' => 'No questions added yet.',
        ],
        'label' => [
            'question' => 'Question',
            'option' => 'Option',
        ],
        'button' => [
            'add_option' => 'Add option',
            'add_question' => 'Add question',
        ],

    ],
    'settings' => [
        'title' => 'Settings',
        'section_titles' => [
            'security' => 'Poll security',
            'settings' => 'Poll settings',
        ],
        'tooltip' => 'Set the poll settings.',
        'comments' => [
            'label' => 'Allow comments',
            'tooltip' => 'Allow participants to add comments to the poll.',
        ],
        'anonymous' => [
            'label' => 'Anonymous voting',
            'tooltip' => 'Allow participants to vote anonymously.',
        ],
        'hide_results' => [
            'label' => 'Hide results',
            'tooltip' => 'Hide the results of the poll until the deadline.',
        ],
        'edit_votes' => [
            'label' => 'Allow vote editing',
            'tooltip' => 'Allow participants to edit their votes after submission.',
        ],
        'invite_only' => [
            'label' => 'Invite only',
            'tooltip' => 'Permit only invited users to access the poll.',
        ],
        'add_time_options' => [
            'label' => 'Users can add time options',
            'tooltip' => 'Allow participants to add their own time options to the poll.',
        ],
        'allow_invalid' => [
            'label' => 'Allow vote for past options',
            'tooltip' => 'Allow participants to vote options that already passed.',
        ],
        'password' => [
            'label' => 'Password',
            'tooltip' => 'Set a password for the poll. Only users with the password can access the poll.',
            'placeholder' => 'Enter password',
        ],
    ],
    'button' => [
        'return' => 'Return to poll',
        'submit' => 'Save Poll',
    ],

    'messages' => [
        'success' => 'Anketa byla úspěšně uložena.',
        'error' => [
            'dirty' => 'The poll has been updated by another user. Please refresh the page.',
            'saving' => 'An error occurred while saving the poll.',
        ],
    ],

    'loading' => 'Saving...',
];
