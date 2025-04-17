<?php

return [
    'share' => [
        'title' => 'Sdílení ankety',
        'labels' => [
            'link' => 'Odkaz pro hlasující',
            'admin_link' => 'Odkaz pro správce',
        ],
        'text' => [
            'link' => 'Sdílejte tento odkaz s účastníky, aby mohli hlasovat v anketu.',
            'admin_link' => 'Tento odkaz je určen pro správce. Přidá oprávnění pro správu ankety.',
            'text_copied' => 'Odkaz zkopírován!',
        ],
        'button' => [
            'copy' => 'Kopírovat',
            'copied' => 'Zkopírováno',
        ]
    ],
    'add_new_time_option' => [
        'title' => 'Přidat novou časovou možnost do :poll_title',
        'buttons' => [
            'time_option' => 'Časová možnost',
            'text_option' => 'Textová možnost',
            'add_option' => 'Přidat možnost',
        ],
        'date' => [
            'label' => 'Datum',
            'placeholder' => 'Vyberte datum',
        ],
        'start_time' => [
            'label' => 'Čas začátku',
            'placeholder' => 'Vyberte čas začátku',
        ],
        'end_time' => [
            'label' => 'Čas konce',
            'placeholder' => 'Vyberte čas konce',
        ],
        'text' => [
            'label' => 'Text',
            'placeholder' => 'Zadejte textovou možnost',
        ],
        'messages' => [
            'error' => [
                'no_permissions' => 'Nemáte oprávnění přidat tuto možnost.',
                'duplicates' => 'Neplatný formát data.',
            ],
        ],
        'loading' => 'Přidávání...',
    ],
    'results' => [
        'title' => 'Výsledky ankety',
        'alert' => [
            'no_votes' => 'Zatím žádné hlasy.',
            'anonymous_votes' => 'Hlasy jsou anonymní. Vidíte pouze své vlastní hlasy.',
        ],
        'buttons' => [
            'delete_vote' => 'Smazat hlas',
            'load_vote' => 'Načíst hlas',
        ],
        'messages' => [
            'error' => [
                'delete' => 'Nemůžete smazat tento hlas.',
                'load' => 'Nemůžete načíst tento hlas.',
            ],
        ],
    ],
    'create_event' => [
        'buttons' => [
            'import_from_results' => 'Importovat z výsledků ankety',
            'delete_event' => 'Smazat událost',
            'create_event' => 'Vytvořit událost',
            'update_event' => 'Aktualizovat událost',
        ],
        'title' => 'Vytvořit událost pro anketu :poll_title',
        'description' => 'Vyplňte níže uvedené údaje pro vytvoření události a případně importujte konečné možnosti z výsledků ankety.',
        'event_title' => [
            'label' => 'Název události',
            'placeholder' => 'Zadejte název události',
        ],
        'start_time' => [
            'label' => 'Začátek',
            'placeholder' => 'Vyberte čas začátku události',
        ],
        'end_time' => [
            'label' => 'Konec',
            'placeholder' => 'Vyberte čas konce události',
        ],
        'event_description' => [
            'label' => 'Popis události',
            'placeholder' => 'Zadejte popis události...',
        ],
        'messages' => [
            'error' => [
                'no_permissions' => 'Nemáte oprávnění vytvořit událost.',
            ],
            'success' => [
                'event_created' => 'Událost byla úspěšně vytvořena.',
                'event_updated' => 'Událost byla úspěšně aktualizována.',
                'event_deleted' => 'Událost byla úspěšně smazána.',
            ],
        ]
    ],
    'invitations' => [
        'title' => 'Pozvat účastníky',
        'text' => 'Odeslat nové pozvání',
        'emails' => [
            'label' => 'E-maily',
            'placeholder' => 'Vložte více e-mailů oddělených čárkami (,)',
        ],
        'table' => [
            'headers' => [
                'email' => 'E-mail',
                'status' => 'Stav',
                'sent_at' => 'Odesláno',
                'actions' => 'Akce',
            ],
            'status' => [
                'pending' => 'Čeká na otevření',
                'sent' => 'Odesláno',
                'failed' => 'Selhalo',
            ],
            'actions' => [
                'resend' => 'Znovu odeslat',
                'delete' => 'Smazat',
            ],
        ],
        'buttons' => [
            'send' => 'Odeslat pozvání',
        ],
        'loading' => 'Odesílání...',
        'message' => [
            'success' => 'Pozvání bylo úspěšně odesláno.',
            'error' => [
                'closed' => 'Pozvání lze odesílat pouze k aktivním anketám.',
                'general' => 'Při odesílání pozvání došlo k chybě.',
                'no_permissions' => 'Nemáte oprávnění odesílat pozvání.',
            ],
        ],
        'alerts' => [
            'error' => [
                'closed' => 'Tato anketa je uzavřena. Nelze odesílat pozvání.',
            ],
            'info' => [
                'no_invitations' => 'Zatím nebyla odeslána žádná pozvání.',
            ],
        ],
    ],
    'close_poll' => [
        'title' => [
            'close' => 'Uzavřít anketu',
            'reopen' => 'Znovu otevřít anketu',
        ],
        'text' => [
            'reopen' => 'Chcete znovu otevřít tuto anketu? Uživatelé budou moci znovu hlasovat.',
            'poll_count' => 'Tato anketa má :count_poll_votes hlasů. Uzavřením ankety zabráníte dalšímu hlasování.',
            'is_user_sure' => 'Opravdu chcete uzavřít tuto anketu? Po uzavření již nebudou přijímány žádné další hlasy.',
        ],
        'buttons' => [
            'close' => 'Uzavřít anketu',
            'reopen' => 'Znovu otevřít anketu',
            'cancel' => 'Zrušit',
        ],
        'labels' => [
            'new_deadline' => 'Nový termín',
            'new_deadline_placeholder' => 'Vyberte nový termín',
        ],
        'alerts' => [
            'no_votes' => 'Tato anketa nemá žádné hlasy. Anketu lze uzavřít pouze v případě, pokud hlasoval alespoň jeden uživatel.',
            'event_will_be_deleted' => 'Upozornění: Pokud jste vytvořili událost, bude smazána.',
        ],
        'messages' => [
            'success' => [],
            'error' => [],
        ],
    ],
    'choose_final_options' => [
        'title' => 'Uzavřít anketu',
        'description' => 'Nejlepší možnosti jsou již vybrány. Pokud chcete, můžete vybrat jiné možnosti. Tyto možnosti budou vloženy do formuláře pro vytvoření události.',
        'accordion' => [
            'poll_options' => 'Možnosti hlasování',
            'table_headers' => [
                'option' => 'Možnost',
                'score' => 'Skóre',
                'select' => 'Vybrat',
            ],
        ],
        'buttons' => [
            'insert_to_calendar' => 'Vložit do kalendáře',
        ],
    ],
    'delete_poll' => [
        'title' => 'Smazat anketu',
        'text' => [
            'question' => 'Opravdu chcete smazat tuto anketu?',
            'warning' => 'Tuto akci nelze vrátit zpět.',
        ],
        'buttons' => [
            'delete' => 'Smazat anketu',
            'cancel' => 'Zrušit',
        ],
    ],
    'error' => [
        'title' => 'Chyba',
        'text' => 'Při zpracování vašeho požadavku došlo k chybě. Zkuste to prosím znovu později.',
    ],
];
