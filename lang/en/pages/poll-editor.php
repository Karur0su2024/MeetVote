<?php

return [

    // Základní informace o anketě
    'basic_info' => [
        'title' => 'Basic information',
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
        'post_anonymously' => [
            'label' => 'Post poll anonymously',
            'tooltip' => 'If you want to post the poll anonymously, you can do so by checking this option. This will hide your name and email from the poll.',
        ],
        'user_name' => [
            'label' => 'Your name',
            'placeholder' => 'John Doe',
        ],
        'user_email' => [
            'label' => 'Your email',
            'placeholder' => 'example@email.com',
        ],
    ],

    // Nastavení časových termínů
    'section.title.time_options' => 'Time options',
    'section.tooltip.time_options' => 'Select available dates and time slots for participants to vote on.',

    'subsection.title.calendar' => 'Calendar',
    'subsection.title.dates' => 'Chosen dates',

    'button.time_option_time' => 'Add time option',
    'button.time_option_text' => 'Add text option',

    // Otázky ankety
    'section.title.questions' => 'Additional questions',
    'section.tooltip.questions' => 'Add additional questions to the poll. Questions are not required.',

    'alert.no_questions' => 'No questions added yet.',

    'button.add_option' => 'Add option',
    'button.add_question' => 'Add question',

    // Nastavení ankety
    'section.title.settings' => 'Settings',
    'section.tooltip.settings' => 'Set the poll settings.',

    'label.comments' => 'Comments',
    'tooltip.comments' => 'Allow participants to add comments to the poll.',

    'label.anonymous' => 'Anonymous voting',
    'tooltip.anonymous' => 'Allow participants to vote anonymously.',

    'label.hide_results' => 'Hide results',
    'tooltip.hide_results' => 'Hide the results of the poll until the deadline.',

    'label.edit_votes' => 'Allow vote editing',
    'tooltip.edit_votes' => 'Allow participants to edit their votes after submission.',

    'label.invite_only' => 'Invite only',
    'tooltip.invite_only' => 'Permit only invited users to access the poll.',

    'label.add_time_options' => 'Users can add time options',
    'tooltip.add_time_options' => 'Allow participants to add their own time options to the poll.',

    'label.password' => 'Password',
    'tooltip.password' => 'Set a password for the poll. Only users with the password can access the poll.',


    // Odeslání ankety
    'button.submit' => 'Submit',

];
