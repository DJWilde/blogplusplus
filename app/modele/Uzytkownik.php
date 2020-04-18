<?php
    class Uzytkownik {
        // Łącznik z bazą danych
        private $baza_danych;

        public function __construct() {
            // Utworzenie połączenia z bazą danych
            $this->baza_danych = new BazaDanych();
        }

        public function pobierzUzytkownikow() {
            $this->baza_danych->zapytanie('SELECT * FROM uzytkownicy');

            $wyniki = $this->baza_danych->zbiorWynikow();

            return $wyniki;
        }

        // Metoda odpowiedzialna za rejestrację użytkownika
        public function zarejestruj($dane) {
            $this->baza_danych->zapytanie('INSERT INTO uzytkownicy (nazwa_uzytkownika, imie, nazwisko, email, haslo) VALUES
                                            (:nazwa_uzytkownika, :imie, :nazwisko, :email, :haslo)');
            $this->baza_danych->dowiaz(':nazwa_uzytkownika', $dane['nazwa_uzytkownika']);
            $this->baza_danych->dowiaz(':imie', $dane['imie']);
            $this->baza_danych->dowiaz(':nazwisko', $dane['nazwisko']);
            $this->baza_danych->dowiaz(':email', $dane['email']);
            $this->baza_danych->dowiaz(':haslo', $dane['haslo']);

            if ($this->baza_danych->wykonaj()) {
                return true;
            } else {
                return false;
            }
        }

        // Metoda odpowiedzialna za logowanie użytkownika (znajduje po adresie e-mail)
        public function zaloguj($email, $haslo) {
            // Zapytanie do bazy danych
            $this->baza_danych->zapytanie('SELECT * FROM uzytkownicy WHERE email = :email');

            // Dowiązanie parametru
            $this->baza_danych->dowiaz(':email', $email);

            // Zwrócenie wyniku
            $wynik = $this->baza_danych->pojedynczyWynik();

            // Weryfikacja hasła
            $haszowane_haslo = $wynik->haslo;
            if (password_verify($haslo, $haszowane_haslo)) {
                return $wynik;
            } else {
                return false;
            }
        }

        public function znajdzUzytkownikaPoEmail($email) {
            // Zapytanie do bazy danych
            $this->baza_danych->zapytanie('SELECT * FROM uzytkownicy WHERE email = :email');

            // Dowiązanie parametru
            $this->baza_danych->dowiaz(':email', $email);

            // Zwrócenie wyniku
            $wynik = $this->baza_danych->pojedynczyWynik();

            // Sprawdzenie czy istnieje użytkownik
            if ($this->baza_danych->liczbaWynikow() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function znajdzUzytkownikaPoNazwie($nazwa) {
            // Zapytanie do bazy danych
            $this->baza_danych->zapytanie('SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika = :nazwa_uzytkownika');

            // Dowiązanie parametru
            $this->baza_danych->dowiaz(':nazwa_uzytkownika', $nazwa);

            // Zwrócenie wyniku
            $wynik = $this->baza_danych->pojedynczyWynik();

            // Sprawdzenie czy istnieje użytkownik
            if ($this->baza_danych->liczbaWynikow() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function pobierzUzytkownikaPoId($id) {
            // Zapytanie do bazy danych
            $this->baza_danych->zapytanie('SELECT * FROM uzytkownicy WHERE id = :id');

            // Dowiązanie parametru
            $this->baza_danych->dowiaz(':id', $id);

            // Zwrócenie wyniku
            return $this->baza_danych->pojedynczyWynik();
        }

        public function aktualizujUzytkownika($dane) {
            $this->baza_danych->zapytanie('UPDATE uzytkownicy SET nazwa_uzytkownika = :nazwa_uzytkownika,
                                            imie = :imie, nazwisko = :nazwisko, email = :email WHERE id = :id');
            $this->baza_danych->dowiaz(':id', $dane['id']);
            $this->baza_danych->dowiaz(':nazwa_uzytkownika', $dane['nazwa_uzytkownika']);
            $this->baza_danych->dowiaz(':imie', $dane['imie']);
            $this->baza_danych->dowiaz(':nazwisko', $dane['nazwisko']);
            $this->baza_danych->dowiaz(':email', $dane['email']);

            if ($this->baza_danych->wykonaj()) {
                return true;
            } else {
                return false;
            }
        }

        public function aktualizujHaslo($dane) {
            $this->baza_danych->zapytanie('UPDATE uzytkownicy SET haslo = :haslo WHERE id = :id AND nazwa_uzytkownika = :nazwa_uzytkownika AND
                                            imie = :imie AND nazwisko = :nazwisko AND email = :email');
            $this->baza_danych->dowiaz(':haslo', $dane['haslo']);
            $this->baza_danych->dowiaz(':id', $dane['id']);
            $this->baza_danych->dowiaz(':nazwa_uzytkownika', $dane['nazwa_uzytkownika']);
            $this->baza_danych->dowiaz(':imie', $dane['imie']);
            $this->baza_danych->dowiaz(':nazwisko', $dane['nazwisko']);
            $this->baza_danych->dowiaz(':email', $dane['email']);
        }
    }