<?php
    // Wczytaj plik konfiguracyjny
    require_once 'konfiguracja/konfiguracja.php';

    // Wczytaj funkcje pomocnicze
    require_once 'pomocnicze/gravatar.php';
    require_once 'pomocnicze/przekieruj.php';
    require_once 'pomocnicze/sesja.php';

    // Wczytaj pliki biblioteczne (automatyzacja :O)
    spl_autoload_register(function($nazwaKlasy) {
        require_once 'biblioteki/' . $nazwaKlasy . '.php';
    });