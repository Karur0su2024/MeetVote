<?php

return [

    'page' => [
        'create' => 'Vytvoření nové ankety',
        'edit' => [
            'title' => 'Upravení ankety :poll_title',
        ],
    ],

    // Základní informace o anketě
    'basic_info' => [
        'title' => 'Informace o anketě',

        'section' => [
            'poll' => 'Informace o anketě',
            'user' => 'Informace o uživateli',
        ],

        'poll_title' => [
            'label' => 'Název ankety',
            'placeholder' => 'Anketa #1',
        ],
        'poll_description' => [
            'label' => 'Popis ankety',
            'placeholder' => 'Popis vaší ankety...',
        ],
        'poll_deadline' => [
            'label' => 'Uzávěrka',
            'placeholder' => 'Zadejte uzávěrku ankety',
            'tooltip' => 'Nastavte uzávěrku ankety. Po tomto datu již nebude možné hlasovat. Uzávěrka není povinná.',
        ],
        'poll_timezone' => [
            'label' => 'Časové pásmo',
            'placeholder' => 'Vyberte časové pásmo',
            'tooltip' => 'Vyberte časové pásmo ankety. Toto pásmo bude použito pro zobrazení časů ankety.',
        ],
        'user_name' => [
            'label' => 'Vaše jméno',
            'placeholder' => 'Jan Novák',
        ],
        'user_email' => [
            'label' => 'Váš email',
            'placeholder' => 'adresa@email.com',
        ],
    ],
    // Sekce s časovými možnostmi
    'time_options' => [
        'title' => 'Časové možnosti',
        'section_titles' => [
            'settings' => 'Nastavení ankety',
            'security' => 'Nastavení bezpečnosti',
        ],
        'tooltip' => 'Vyberte dostupná data a časové sloty, na které mohou účastníci hlasovat.',
        'calendar' => [
            'title' => 'Kalendář',
            'dates' => 'Vybraná data',
        ],
        'label' => [
            'start' => 'Začátek',
            'end' => 'Konec',
        ],
        'button' => [
            'delete' => 'Smazat',
            'add_empty_time_option' => 'Přidat prázdnou časovou možnost',
            'add_hour_time_option' => 'Přidat hodinovou časovou možnost',
            'add_text_option' => 'Přidat textovou možnost',
        ],
        'error_messages' => [
            'empty_start' => 'Začátek časové možnosti je povinný.',
            'empty_end' => 'Konec časové možnosti je povinný.',
            'empty_text' => 'Textová možnost je povinná.',
            'format_start' => 'Začátek časové možnosti je ve špatném formátu.',
            'format_end' => 'Konec časové možnosti je ve špatném formátu.',
            'after_start' => 'Konec časové možnosti musí být po začátku.',
        'duplicate_options' => 'Duplicitní časové možnosti nejsou povoleny.',
        ],
    ],
    // Sekce s otázkami
    'questions' => [
        'title' => 'Otázky',
        'tooltip' => 'Přidejte dodatečné otázky do ankety, např. pro výběr lokace nebo typu akce.',
        'alert' => [
            'no_questions' => 'Zatím nebyly přidány žádné otázky.',
        ],
        'label' => [
            'question' => 'Otázka',
            'option' => 'Možnost',
        ],
        'messages' => [
            'error' => [
                'duplicate_titles' => 'Duplicitní názvy otázek nejsou povoleny.',
                'duplicate_options' => 'Duplicitní možnosti otázek nejsou povoleny.',
            ],
        ],
        'button' => [
            'add_option' => 'Přidat možnost',
            'add_question' => 'Přidat otázku',
        ],

    ],
    'settings' => [
        'title' => 'Nastavení',
        'tooltip' => 'Nastavte možnosti ankety.',
        'section_titles' => [
            'security' => 'Zabezpečení ankety',
            'settings' => 'Nastavení ankety',
        ],
        'comments' => [
            'label' => 'Povolit komentáře',
            'tooltip' => 'Povolit účastníkům přidávat komentáře k anketě.',
        ],
        'anonymous' => [
            'label' => 'Anonymní hlasování',
            'tooltip' => 'Povolit účastníkům hlasovat anonymně.',
        ],
        'hide_results' => [
            'label' => 'Skrýt průběžné výsledky',
            'tooltip' => 'Skrýt výsledky ankety až do uzávěrky.',
        ],
        'invite_only' => [
            'label' => 'Pouze na pozvání',
            'tooltip' => 'Povolit přístup k anketě pouze pozvaným uživatelům.',
        ],
        'add_time_options' => [
            'label' => 'Uživatelé mohou přidávat časové možnosti',
            'tooltip' => 'Povolit účastníkům přidávat vlastní časové možnosti do ankety.',
        ],
        'allow_invalid' => [
            'label' => 'Povolit hlasování pro již propadlé možnosti',
            'tooltip' => 'Povolit účastníkům hlasovat pro možnosti, které jsou v minulosti',
        ],
        'password' => [
            'label' => 'Heslo',
            'tooltip' => 'Nastavte heslo pro anketu. Přístup k anketě budou mít pouze uživatelé s heslem.',
            'placeholder' => 'Zadejte heslo',
        ],
    ],
    'button' => [
        'return' => 'Zpět k anketě',
        'submit' => 'Uložit anketu',
    ],

    'messages' => [
        'success' => 'Anketa byla úspěšně uložena.',
        'error' => [
            'dirty' => 'Anketa byla upravena jiným uživatelem. Obnovte prosím stránku.',
            'saving' => 'Při ukládání ankety došlo k chybě.',
            'general' => 'Formulář obsahuje chyby. Zkontrolujte prosím všechna pole.',
        ],


    ],

    'loading' => 'Ukládání...',
];
