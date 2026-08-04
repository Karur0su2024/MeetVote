<?php

return [
    'register' => [
        'title' => 'Registrace',
        'labels' => [
            'name' => 'Jméno',
            'email' => 'E-mail',
            'password' => 'Heslo',
            'confirm_password' => 'Potvrzení hesla',
        ],
        'buttons' => [
            'already_registered' => 'Už máte účet? Přihlaste se',
            'register' => 'Registrovat',
            'with_google' => 'Přihlásit se přes Google',
        ],
        'messages' => [
            'status' => 'Registrace byla úspěšná!',
        ],
        'loading' => 'Zpracovávám registraci...',
    ],

    'login' => [
        'title' => 'Přihlášení',

        'labels' => [
            'email' => 'E-mail',
            'password' => 'Heslo',
            'remember_me' => 'Zapamatovat si mě',
        ],
        'buttons' => [
            'not_registered' => 'Nemáte účet? Zaregistrujte se',
            'forgot_password' => 'Zapomněli jste heslo?',
            'login' => 'Přihlásit se',
            'with_google' => 'Přihlásit se přes Google',
        ],
        'messages' => [
            'status' => 'Přihlášení bylo úspěšné!',
        ],
        'loading' => 'Přihlašuji...',
    ],

    'forgot_password' => [
        'title' => 'Zapomenuté heslo',

        'description' => 'Zadejte prosím svou e-mailovou adresu pro zaslání odkazu na obnovení hesla.',
        'labels' => [
            'email' => 'E-mail',
        ],
        'buttons' => [
            'send' => 'Odeslat odkaz na obnovení hesla',
        ],
        'messages' => [
            'status' => 'Odkaz na obnovení hesla byl odeslán! Zkontrolujte prosím svůj e-mail.',
        ],
        'loading' => 'Odesílám odkaz na obnovení hesla...',
    ],

    'reset_password' => [
        'title' => 'Obnovení hesla',

        'description' => 'Zadejte prosím své nové heslo.',
        'labels' => [
            'password' => 'Heslo',
            'confirm_password' => 'Potvrzení hesla',
        ],
        'buttons' => [
            'reset' => 'Obnovit heslo',
        ],
        'messages' => [
            'status' => 'Heslo bylo úspěšně obnoveno! Nyní se můžete přihlásit s novým heslem.',
        ],
        'loading' => 'Obnovuji heslo...',
    ],

];
