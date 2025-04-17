<?php

return [

    'title' => 'User settings',

    'profile_settings' => [
        'title' => 'Profile Information',
        'labels' => [
            'name' => 'Your name',
            'email' => 'Your email',
        ],
        'buttons' => [
            'save' => 'Save Changes',
        ],
    ],
    'password' => [

        'title' => 'Password',
        'labels' => [
            'old_password' => 'Current password',
            'new_password' => 'New password',
            'new_password_confirmation' => 'Confirm new password',
        ],
        'buttons' => [
            'save' => 'Save Changes',
        ],
    ],
    'google' => [

        'title' => 'Google & Calendar',
        'buttons' => [
            'disconnect' => 'Disconnect from Google',
            'connect' => 'Connect with Google',
        ],
        'connected' => [
            'text' => 'Your account is connected to Google. You can disconnect it if you want.',
        ],
        'text' => [
            'synced_events' => 'You have currently :synced_events_count events synced with your Google Calendar.',
        ],
    ],
    'delete_account' => [
        'title' => 'Delete account',
        'description' => 'Deleting your account will remove all your data from our servers.
                            This action cannot be undone.',
        'buttons' => [
            'delete_account' => 'Delete account',
        ],
    ],

];
