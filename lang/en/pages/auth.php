<?php

return [
    'register' => [
        'title' => 'Register',
        'labels' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm password',
        ],
        'buttons' => [
            'already_registered' => 'Already have an account? Log in',
            'register' => 'Register',
            'with_google' => 'Log in with Google',
        ],
        'messages' => [
            'status' => 'Registration successful!',
        ],
        'loading' => 'Processing registration...',
    ],

    'login' => [
        'title' => 'Login',

        'labels' => [
            'email' => 'Email',
            'password' => 'Password',
            'remember_me' => 'Remember me',
        ],
        'buttons' => [
            'not_registered' => 'Don\'t have an account? Register',
            'forgot_password' => 'Forgot your password?',
            'login' => 'Log in',
            'with_google' => 'Log in with Google',
        ],
        'messages' => [
            'status' => 'Login successful!',
        ],
        'loading' => 'Logging in...',
    ],

    'forgot_password' => [
        'title' => 'Forgot Password',

        'description' => 'Please enter your email address to receive a password reset link.',
        'labels' => [
            'email' => 'Email',
        ],
        'buttons' => [
            'send' => 'Send password reset link',
        ],
        'messages' => [
            'status' => 'Password reset link sent! Please check your email.',
        ],
        'loading' => 'Sending password reset link...',
    ],

    'reset_password' => [
        'title' => 'Reset Password',

        'description' => 'Please enter your new password.',
        'labels' => [
            'password' => 'Password',
            'confirm_password' => 'Confirm password',
        ],
        'buttons' => [
            'reset' => 'Reset password',
        ],
        'messages' => [
            'status' => 'Password reset successful! You can now log in with your new password.',
        ],
        'loading' => 'Resetting password...',
    ],

];
