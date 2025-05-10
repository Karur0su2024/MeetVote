<?php

return [

    'title' => 'Nastavení uživatele',

    'profile_settings' => [
        'title' => 'Informace o profilu',
        'labels' => [
            'name' => 'Vaše jméno',
            'email' => 'Vaše emailová adresa',
        ],
        'buttons' => [
            'save' => 'Uložit změny',
        ],
    ],
    'password' => [

        'title' => 'Heslo',
        'labels' => [
            'old_password' => 'Vaše aktuální heslo',
            'new_password' => 'Nové heslo',
            'new_password_confirmation' => 'Potvrďte nové heslo',
        ],
        'buttons' => [
            'save' => 'Uložit změny',
        ],
    ],
    'google' => [

        'title' => 'Google & Kalendář',
        'buttons' => [
            'disconnect' => 'Odpojit účet Google',
            'connect' => 'Připojit účet Google',
            'connect_calendar' => 'Připojit Kalendář',
            'disconnect_calendar' => 'Odpojit Kalendář',
        ],
        'connected' => [
            'text' => 'Vaše účet je propojen s Googlem. Můžete jej odpojit, pokud chcete.',
        ],
        'text' => [
            'synced_events' => 'Máte aktuálně :synced_events_count událostí synchronizovaných s vaším Google Kalendářem.',
        ],
    ],
    'delete_account' => [
        'title' => 'Odstranit účet',
        'description' => 'Odstranění vašeho účtu odstraní všechna vaše data.
                        Tuto akci nelze vrátit zpět.',
        'buttons' => [
            'delete_account' => 'Odstranit účet',
        ],
    ],

];
