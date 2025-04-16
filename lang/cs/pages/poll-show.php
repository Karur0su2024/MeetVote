<?php

return [

    'settings' => [
        'dropdown' => [
            'options' => 'Možnosti',
            'edit_poll' => 'Upravit anketu',
            'invitations' => 'Pozvánky',
            'share_poll' => 'Sdílet anketu',
            'close_poll' => 'Uzavřít anketu',
            'reopen_poll' => 'Znovu otevřít anketu',
            'delete_poll' => 'Smazat anketu',
        ],
    ],
    'info' => [
        'text' => [
            'no_description' => 'Bez popisu',
        ],
        'badges' => [
            'status' => [
                'active' => 'Aktivní anketa',
                'closed' => 'Uzavřená anketa',
            ],
            'attributes' => [
                'anonymous_votes' => 'Hlasy jsou anonymní',
                'comments' => 'Komentáře povoleny',
                'invite_only' => 'Pouze na pozvání',
                'hide_results' => 'Skryté výsledky',
                'password_protected' => 'Chráněno heslem',
                'add_time_options' => 'Hlasující mohou přidávat časové možnosti',
            ],
        ],
    ],
    'event_details' => [
        'title' => 'Detaily události',
        'dropdown' => [
            'header' => 'Import',
            'import_to_google' => 'Importovat do Google Kalendáře',
            'import_to_outlook' => 'Importovat do Outlook Kalendáře',
        ],
        'text' => [
            'synced_with_google' => 'Synchronizováno s Google Kalendářem',
            'start_time' => 'Čas začátku:',
            'end_time' => 'Čas konce:',
            'no_event_created_yet' => 'Pro tuto anketu zatím nebyla vytvořena žádná událost.',
            'poll_still_open' => 'Anketa je stále otevřená.',
            'admin_can_create_event' => 'Událost může být vytvořena pouze pro uzavřené ankety.',
            'event_will_be_created' => 'Událost bude vytvořena, jakmile administrátor vybere finální možnosti.',
        ],
        'buttons' => [
            'update_event' => 'Aktualizovat událost',
            'pick_from_results' => 'Manuálně',
            'automatically_create_event' => 'Automaticky',
            'close_poll' => 'Uzavřít anketu',
        ],
    ],
    'voting' => [
        'title' => 'Hlasování',
        'description' => 'Vyberte čas, který vám nejlépe vyhovuje pro schůzku.',
        'sections' => [
            'time_options' => [
                'title' => 'Časové možnosti',
                'tooltip' => 'Vyberte čas, který vám nejlépe vyhovuje pro schůzku.',
            ],
        ],
        'form' => [
            'title' => 'Vaše informace',
            'username' => [
                'label' => 'Uživatelské jméno',
                'placeholder' => 'Zadejte své uživatelské jméno',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Zadejte svůj email',
            ],
            'notes' => [
                'label' => 'Dodatečné poznámky',
                'placeholder' => 'Vaše dodatečné poznámky k anketě...',
            ],
            'loading' => 'Odesílání...',
        ],
        'buttons' => [
            'add_time_option' => 'Přidat novou časovou možnost',
            'results' => 'Výsledky',
            'submit_vote' => 'Odeslat hlas',
            'check_availability' => [
                'label' => 'Zkontrolovat dostupnost v kalendáři',
                'tooltip' => 'Zkontrolujte svou dostupnost v Google Kalendáři',
                'loading' => 'Kontroluji dostupnost...',
            ],
            'show_result_section' => [
                'label' => 'Zobrazit výsledky',
            ],
        ],
        'alert' => [
            'poll_closed' => 'Anketa je uzavřena. Nemůžete již hlasovat.',
        ],
    ],
    'results' => [
        'title' => 'Výsledky',
        'description' => 'Zde můžete vidět výsledky ankety.',
        'sections' => [
            'all_votes' => [
                'title' => 'Všechny hlasy',
                'empty' => 'Zatím žádné hlasy.',
                'anonymous' => 'Anonymní',
            ],
            'results' => [
                'view_only' => [
                    'title' => 'Výsledky',
                    'section' => [
                        'time_options' => 'Časové možnosti',
                    ],
                ],
                'pick_from_results' => [
                    'title' => 'Vyberte finální výsledky',
                    'description' => 'Vyberte možnosti, které chcete použít pro vytvoření události.
                                    Událost představuje finální výsledky ankety.',
                    'section' => [
                        'time_options' => 'Časové možnosti',
                    ],
                    'buttons' => [
                        'create_event' => [
                            'label' => 'Vytvořit událost',
                            'tooltip' => 'Otevřete modální okno pro vytvoření události a předvyplňte jej vybranými výsledky.
                                        Poté můžete událost sdílet se svými přáteli.',
                        ]
                    ]
                ],
                'buttons' => [
                    'show_voting_section' => 'Zobrazit hlasování',
                ],
            ],
        ],
        'alerts' => [
            'hidden' => 'Výsledky ankety jsou skryté tvůrcem ankety.',
        ],
    ],
    'comments' => [
        'title' => 'Komentáře',
        'form' => [
            'title' => 'Komentáře',
            'username' => [
                'label' => 'Uživatelské jméno',
                'placeholder' => 'Zadejte své uživatelské jméno',
            ],
            'content' => [
                'label' => 'Vaše zpráva',
                'placeholder' => 'Napište komentář...',
            ],
            'loading' => 'Odesílání...',
        ],
        'buttons' => [
            'submit' => 'Odeslat komentář',
            'delete_comment' => 'Smazat komentář',
        ],

        'alert' => [
            'disabled' => 'Sekce komentářů je pro tuto anketu zakázána.',
            'no_comments_yet' => 'Zatím žádné komentáře.',
        ],
    ],
    'your_vote' => [
        'title' => 'Váš hlas',
        'no_vote' => 'Ještě jste nehlasovali.',
        'buttons' => [
            'delete' => 'Smazat hlas',
        ],
    ],
];
