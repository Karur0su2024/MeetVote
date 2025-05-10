<?php

return [
    'title' => 'Stránka s přehledem',
    'titles' => [
        'your_polls' => 'Vaše ankety',
        'voted_polls' => 'Ankety, ve kterých jste hlasovali',
    ],
    'cards' => [
        'poll_count' => 'V současnosti máte :polls_count anket.',
    ],
    'dropdowns' => [
        'filter' => [
            'title' => 'Filtrovat',
            'items' => [
                'all' => 'Všechny',
                'active' => 'Pouze aktivní',
                'closed' => 'Pouze uzavřené',
            ],
        ],
        'opened' => [
            'items' => [
                'polls' => 'Ankety',
                'events' => 'Události',
            ],
        ]
    ],
    'buttons' => [
        'new_poll' => 'Nová anketa',
    ],
    'alerts' => [
        'no_polls' => 'Nenalezeny žádné ankety.',
        'no_events' => 'Nemáte zatím žádné události.',
        'no_connected_calendar' => [
            'text' => 'Můžete synchronizovat své události s Google Kalendářem. Chcete-li to provést, prosím, propojte svůj účet Google v ',
            'link' => 'nastavení',
        ]
    ],

    'poll_card' => [
        'dropdown' => [
            'edit' => 'Upravit',
            'share' => 'Sdílet',
            'results' => 'Výsledky',
            'delete' => 'Odstranit',
        ],
        'pills' => [
            'status' => [
                'active' => 'Aktivní',
                'closed' => 'Uzavřeno',
            ],
            'admin' => 'Správce',
            'voted' => 'Odhlasováno',
        ],
        'stats' => [
            'votes' => 'Odpovědi',
            'time_options' => 'Časové možnosti',
            'questions' => 'Otázky',
        ],
        'buttons' => [
            'view' => 'Zobrazit anketu',
        ],
    ],

    'event_card' => [
        'buttons' => [
            'view' => "Zobrazit anketu události",
        ],
    ],
];
