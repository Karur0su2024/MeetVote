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
                'allow_invalid' => 'Hlasující mohou hlasovat pro již propadlé možnosti',
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
        'alerts' => [
            'event_created' => 'Událost byla úspěšně vytvořena.',
            'event_updated' => 'Událost byla úspěšně aktualizována.',
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
        'preferences' => [
            'yes' => 'Ano',
            'maybe' => 'Možná',
            'no' => 'Ne',
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
        'messages' => [
            'vote_submitted' => 'Hlas byl úspěšně odeslán.',
            'vote_updated' => 'Hlas byl úspěšně aktualizován.',
            'errors' => [
                'email_invalid' => 'Nemůžete hlasovat s touto adresou.',
                'already_voted' => 'V těto anketě jste již hlasovali.',
                'not_allowed' => 'Nemáte oprávnění hlasovat v této anketě.',
                'vote_not_found' => 'Hlas nebyl nalezen.',
                'vote_not_submitted' => 'Hlas nebyl odeslán.',
                'saving_error' => 'Došlo k neočekávané chybě při ukládání hlasu.',
                'no_option_selected' => 'Musíte vybrat alespoň jednu časovou možnost.',
            ],
        ],
        'alert' => [
            'poll_closed' => 'Anketa je uzavřena. Nemůžete již hlasovat.',
            'deadline' => ':now_poll_deadline dní zbývá do konce hlasování!',
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
                    'title' => 'Vyberte konečné výsledky',
                    'description' => 'Vyberte možnosti, které chcete použít pro vytvoření události.
                                      Událost představuje konečné výsledky ankety.',
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
            'ended' => 'Anketa skončila! Nemůžete již hlasovat.',
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
        'text' => [
            'login_to_change_vote' => 'Svůj hlas můžete změnit pouze pokud se přihlásíte.',
        ],
        'no_vote' => 'Ještě jste nehlasovali.',
        'buttons' => [
            'delete' => 'Smazat hlas',
            'login' => 'Přihlásit se',
        ],
    ],
    'messages' => [
        'errors' => [
            'no_permission_to_access' => 'Nemáte oprávnění pro přístup na tuto stránku.',
            'not_active' => 'Tuto akci nelze provést, protože anketa není aktivní nebo již skončila.',
            'wrong_admin_key' => 'Byl zadán špatný klíč správce ankety.',
            'wrong_password' => 'Špatné heslo.',
        ],
        'success' => [
            'vote_deleted' => 'Odpověď byla úspěšně smazána.',
            'event_created' => 'Událost byla úspěšně vytvořena.',
            'admin_acquired' => 'Jste nyní v režimu správce!',
        ],
    ]
];
