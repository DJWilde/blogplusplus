<?php
    class Post {
        // Łącznik z bazą danych
        private $baza_danych;

        public function __construct() {
            // Utworzenie połączenia z bazą danych
            $this->baza_danych = new BazaDanych();
        }

        // Pobranie postów należących do danego użytkownika
        public function pobierzPostyDanegoUzytkownika($id) {
            $this->baza_danych->zapytanie('SELECT * FROM posty p INNER JOIN uzytkownicy u ON p.id_uzytkownika = u.id WHERE u.id = :id
                                            ORDER BY p.data_utworzenia DESC');

            $this->baza_danych->dowiaz(':id', $id);

            $wynik = $this->baza_danych->zbiorWynikow();
            return $wynik;
        }

        // Tworzenie postów
        public function utworzPost($dane) {
            $this->baza_danych->zapytanie('INSERT INTO posty (id_uzytkownika, tytul, tekst) VALUES (:id_uzytkownika, :tytul, :tekst)');

            // Dowiązanie parametrów
            $this->baza_danych->dowiaz(':id_uzytkownika', $dane['id_uzytkownika']);
            $this->baza_danych->dowiaz(':tytul', $dane['tytul']);
            $this->baza_danych->dowiaz(':tekst', $dane['tekst']);

            // Sprawdzenie czy zapytanie się wykonało
            if ($this->baza_danych->wykonaj()) {
                return true;
            } else {
                return false;
            }
        }

        public function aktualizujPost($dane) {
            $this->baza_danych->zapytanie('UPDATE posty SET tytul = :tytul, tekst = :tekst WHERE id = :id');

            $this->baza_danych->dowiaz(':id', $dane['id']);
            $this->baza_danych->dowiaz(':tytul', $dane['tytul']);
            $this->baza_danych->dowiaz(':tekst', $dane['tekst']);

            if ($this->baza_danych->wykonaj()) {
                return true;
            } else {
                return false;
            }
        }

        // Wyświetlenie posta
        public function pokazPost($id) {
            // Zapytanie
            $this->baza_danych->zapytanie('SELECT * FROM posty WHERE id_posta = :id_posta');

            // Dowiązanie parametrów
            $this->baza_danych->dowiaz(':id_posta', $id);

            $wynik = $this->baza_danych->pojedynczyWynik();

            return $wynik;
        }

        public function usunPost($id) {
            $this->baza_danych->zapytanie('DELETE FROM posty WHERE id = :id');

            $this->baza_danych->dowiaz(':id', $id);

            // Sprawdzenie czy zapytanie się wykonało
            if ($this->baza_danych->wykonaj()) {
                return true;
            } else {
                return false;
            }
        }

        public function liczbaPostowDanegoUzytkownika($id) {
            $this->baza_danych->zapytanie('SELECT * FROM posty p INNER JOIN uzytkownicy u ON p.id_uzytkownika = u.id WHERE u.id = :id
                                            ORDER BY p.data_utworzenia DESC');
            
            $this->baza_danych->dowiaz(':id', $id);

            $wynik = $this->baza_danych->zbiorWynikow();

            return sizeof($wynik);
        }
    }