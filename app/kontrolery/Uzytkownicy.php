<?php
    class Uzytkownicy extends Kontroler {
        public function __construct() {
            
            $this->modelUzytkownika = $this->wczytajModel('Uzytkownik');
        }

        public function lista_uzytkownikow() {
            $uzytkownicy = $this->modelUzytkownika->pobierzUzytkownikow();

            $dane = array(
                'uzytkownicy' => $uzytkownicy,
                'wpisany_uzytkownik' => ''
            );

            $this->wczytajWidok('uzytkownicy/lista_uzytkownikow', $dane);
        }

        public function panel_glowny($id) {
            if (!czyZalogowany()) {
                przekieruj('uzytkownicy/logowanie');
            }

            $uzytkownik = $this->modelUzytkownika->pobierzUzytkownikaPoId($id);

            $dane = array(
                'id' => $id,
                'uzytkownik' => $uzytkownik,
                'gravatar' => gravatar($_SESSION['email'])
            );

            $this->wczytajWidok('uzytkownicy/panel_glowny', $dane);
        }

        public function rejestracja() {
            // Sprawdź czy żądanie jest POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Gdy jest żądanie POST
                // Kroki:
                // 1. Oczyścić tablice $_POST
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // 2. Zadeklarować i oczyścić dane
                $dane = array(
                    'nazwa_uzytkownika' => trim($_POST['nazwa_uzytkownika']),
                    'imie' => trim($_POST['imie']),
                    'nazwisko' => trim($_POST['nazwisko']),
                    'email' => trim($_POST['email']),
                    'haslo' => trim($_POST['haslo']),
                    'potwierdzenie_hasla' => trim($_POST['potwierdzenie_hasla']),
                    'blad_nazwa_uzytkownika' => '',
                    'blad_imie' => '',
                    'blad_nazwisko' => '',
                    'blad_email' => '',
                    'blad_haslo' => '',
                    'blad_potwierdzenie_hasla' => ''
                );

                // 3. Walidacja imienia i nazwiska
                if (empty($dane['imie'])) {
                    $dane['blad_imie'] = 'Wypełnij to pole.';
                }

                if (empty($dane['nazwisko'])) {
                    $dane['blad_nazwisko'] = 'Wypełnij to pole.';
                }

                // 4. Walidacja e-maila i sprawdzenie czy użytkownik o danym adresie e-mail istnieje
                if (empty($dane['email'])) {
                    $dane['blad_email'] = 'Wypełnij to pole.';
                } else {
                    if ($this->modelUzytkownika->znajdzUzytkownikaPoEmail($dane['email'])) {
                        $dane['blad_email'] = 'Użytkownik o podanym adresie e-mail już istnieje.';
                    }
                }

                // 5. Walidacja nazwy użytkownika i sprawdzenie czy użytkownik o danej nazwie użytkownika istnieje
                if (empty($dane['nazwa_uzytkownika'])) {
                    $dane['blad_nazwa_uzytkownika'] = 'Wypełnij to pole.';
                } else {
                    if ($this->modelUzytkownika->znajdzUzytkownikaPoNazwie($dane['nazwa_uzytkownika'])) {
                        $dane['blad_nazwa_uzytkownika'] = 'Użytkownik o podanej nazwie już istnieje.';
                    }
                }

                // 6. Sprawdzenie obecności hasła i ich długości
                if (empty($dane['haslo'])) {
                    $dane['blad_haslo'] = 'Wypełnij to pole.';
                } else if (strlen($dane['haslo']) < 6) {
                    $dane['blad_haslo'] = 'Hasło musi mieć przynajmniej 6 znaków.';
                }

                // 7. Sprawdzenie zgodności haseł
                if (empty($dane['potwierdzenie_hasla'])) {
                    $dane['blad_potwierdzenie_hasla'] = 'Potwierdź swoje hasło.';
                } else {
                    if ($dane['haslo'] !== $dane['potwierdzenie_hasla']) {
                        $dane['blad_potwierdzenie_hasla'] = 'Hasła się nie zgadzają.';
                    }
                }
                
                // 8. Sprawdź czy nie ma błędów
                if (empty($dane['blad_nazwa_uzytkownika']) && empty($dane['blad_imie']) && empty($dane['blad_nazwisko']) &&
                    empty($dane['blad_email']) && empty($dane['blad_haslo']) && empty($dane['blad_potwierdzenie_hasla'])) {
                    // 8.1 Jeżeli nie ma, to haszuj haśli
                    $dane['haslo'] = password_hash($dane['haslo'], PASSWORD_BCRYPT);

                    // 8.2 Zarejestruj użytkownika
                    if ($this->modelUzytkownika->zarejestruj($dane)) {
                        // Wyświetl powiadomienie i powiadom o sukcesie
                        wyswietlPowiadomienie('logowanie_powiadomienie', 'Jesteś już z nami! Wystarczy się tylko zalogować.');
                        przekieruj('uzytkownicy/logowanie');
                    } else { // 9. Jeżeli coś poszło nie tak, to RIP
                        die('Coś poszło nie tak...');
                    }
                } else {
                    // 10. Jeżeli wystąpiły błędy to wyświetl je użytkownikowi z formularzem.
                    wyswietlPowiadomienie('rejestracja_powiadomienie', 'W Twoim formularzu wystąpiły błędy.', 'alert alert-danger');
                    $this->wczytajWidok('uzytkownicy/rejestracja', $dane);
                }
            } else { // Gdy mamy żądanie GET
                $dane = array(
                    'nazwa_uzytkownika' => '',
                    'imie' => '',
                    'nazwisko' => '',
                    'email' => '',
                    'haslo' => '',
                    'potwierdzenie_hasla' => '',
                    'blad_nazwa_uzytkownika' => '',
                    'blad_imie' => '',
                    'blad_nazwisko' => '',
                    'blad_email' => '',
                    'blad_haslo' => '',
                    'blad_potwierdzenie_hasla' => ''
                );

                // Wyświetl pusty formularz
                $this->wczytajWidok('uzytkownicy/rejestracja', $dane);
            }
        }

        public function logowanie() {
            // Sprawdź czy żądanie jest POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Gdy jest żądanie POST
                // Kroki:
                // 1. Oczyścić tablice $_POST
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // 2. Zadeklarować i oczyścić dane
                $dane = array(
                    'email' => trim($_POST['email']),
                    'haslo' => trim($_POST['haslo']),
                    'blad_email' => '',
                    'blad_haslo' => '',
                );

                // 4. Walidacja e-maila i sprawdzenie czy użytkownik o danym adresie e-mail istnieje
                if (empty($dane['email'])) {
                    $dane['blad_email'] = 'Wypełnij to pole.';
                } else {
                    if ($this->modelUzytkownika->znajdzUzytkownikaPoEmail($dane['email'])) {
                        // Znaleziono użytkownika
                    } else {
                        $dane['blad_email'] = 'Nie znaleziono użytkownika o podanym adresie e-mail.';
                    }
                }

                // 6. Sprawdzenie obecności hasła i ich długości
                if (empty($dane['haslo'])) {
                    $dane['blad_haslo'] = 'Wypełnij to pole.';
                }
                
                // 8. Sprawdź czy nie ma błędów
                if (empty($dane['blad_email']) && empty($dane['blad_haslo'])) {
                    // 8.2 Zarejestruj użytkownika
                    $zalogowany_uzytkownik = $this->modelUzytkownika->zaloguj($dane['email'], $dane['haslo']);

                    if ($zalogowany_uzytkownik) {
                        $this->utworzSesje($zalogowany_uzytkownik);
                        wyswietlPowiadomienie('uzytkownik_powiadomienie', 'Zalogowano poprawnie!');
                    } else {
                        $dane['blad_haslo'] = 'Nieprawidłowe hasło.';
                        $this->wczytajWidok('uzytkownicy/logowanie', $dane);
                    }
                } else {
                    // 10. Jeżeli wystąpiły błędy to wyświetl je użytkownikowi z formularzem.
                    wyswietlPowiadomienie('logowanie_niepowodzenie', 'W Twoim formularzu wystąpiły błędy.', 'alert alert-danger');
                    $this->wczytajWidok('uzytkownicy/logowanie', $dane);
                }
            } else { // Gdy mamy żądanie GET
                $dane = array(
                    'email' => '',
                    'haslo' => '',
                    'blad_email' => '',
                    'blad_haslo' => '',
                );

                // Wyświetl pusty formularz
                $this->wczytajWidok('uzytkownicy/logowanie', $dane);
            }
        }

        public function utworzSesje($uzytkownik) {
            $_SESSION['id_uzytkownika'] = $uzytkownik->id;
            $_SESSION['nazwa_uzytkownika'] = $uzytkownik->nazwa_uzytkownika;
            $_SESSION['imie'] = $uzytkownik->imie;
            $_SESSION['nazwisko'] = $uzytkownik->nazwisko;
            $_SESSION['email'] = $uzytkownik->email;
            przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
        }

        public function ustawienia($id) {
            if (!czyZalogowany()) {
                przekieruj('uzytkownicy/logowanie');
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $dane = array(
                    'id' => $id,
                    'id_uzytkownika' => $_SESSION['id_uzytkownika'],
                    'nazwa_uzytkownika' => trim($_POST['nazwa_uzytkownika']),
                    'imie' => trim($_POST['imie']),
                    'nazwisko' => trim($_POST['nazwisko']),
                    'email' => trim($_POST['email']),
                    'haslo' => trim($_POST['haslo']),
                    'potwierdzenie_hasla' => trim($_POST['potwierdzenie_hasla']),
                    'blad_nazwa_uzytkownika' => '',
                    'blad_imie' => '',
                    'blad_nazwisko' => '',
                    'blad_email' => '',
                    'blad_haslo' => '',
                    'blad_potwierdzenie_hasla' => ''
                );
    
                // 3. Walidacja imienia i nazwiska
                if (empty($dane['imie'])) {
                    $dane['blad_imie'] = 'Wypełnij to pole.';
                }

                if (empty($dane['nazwisko'])) {
                    $dane['blad_nazwisko'] = 'Wypełnij to pole.';
                }

                // 4. Walidacja e-maila i sprawdzenie czy użytkownik o danym adresie e-mail istnieje
                if (empty($dane['email'])) {
                    $dane['blad_email'] = 'Wypełnij to pole.';
                } 

                // 5. Walidacja nazwy użytkownika i sprawdzenie czy użytkownik o danej nazwie użytkownika istnieje
                if (empty($dane['nazwa_uzytkownika'])) {
                    $dane['blad_nazwa_uzytkownika'] = 'Wypełnij to pole.';
                }

                // 6. Sprawdzenie obecności hasła i ich długości
                if (empty($dane['haslo'])) {
                    $dane['blad_haslo'] = 'Wypełnij to pole.';
                } else if (strlen($dane['haslo']) < 6) {
                    $dane['blad_haslo'] = 'Hasło musi mieć przynajmniej 6 znaków.';
                }

                // 7. Sprawdzenie zgodności haseł
                if (empty($dane['potwierdzenie_hasla'])) {
                    $dane['blad_potwierdzenie_hasla'] = 'Potwierdź swoje hasło.';
                } else {
                    if ($dane['haslo'] !== $dane['potwierdzenie_hasla']) {
                        $dane['blad_potwierdzenie_hasla'] = 'Hasła się nie zgadzają.';
                    }
                }

                if (empty($dane['blad_nazwa_uzytkownika']) && empty($dane['blad_imie']) && empty($dane['blad_nazwisko']) &&
                    empty($dane['blad_email'])) {
                    if (!empty($dane['haslo']) && !empty($dane['potwierdzenie_hasla'])) {
                        $dane['haslo'] = password_hash($dane['haslo'], PASSWORD_BCRYPT);
                        if ($this->modelUzytkownika->aktualizujHaslo($dane)) {
                            wyswietlPowiadomienie('uzytkownik_powiadomienie', 'Twoje dane zostały pomyślnie zaktualizowane');
                            przekieruj('uzytkownicy/panel_glowny/' . $id);
                        } else {
                            die('Coś poszło nie tak...');
                        }
                    }
                    if ($this->modelUzytkownika->aktualizujUzytkownika($dane)) {
                        wyswietlPowiadomienie('uzytkownik_powiadomienie', 'Twoje dane zostały pomyślnie zaktualizowane');
                        przekieruj('uzytkownicy/panel_glowny/' . $id);
                    } else {
                        die('Coś poszło nie tak...');
                    }
                } else {
                    $this->wczytajWidok('uzytkownicy/ustawienia', $dane);
                }
            } else {
                $uzytkownik = $this->modelUzytkownika->pobierzUzytkownikaPoId($id);

                if (czyDanyUzytkownik($id)) {
                    $dane = array(
                        'id' => $id,
                        'id_uzytkownika' => $_SESSION['id_uzytkownika'],
                        'nazwa_uzytkownika' => trim($uzytkownik->nazwa_uzytkownika),
                        'imie' => trim($uzytkownik->imie),
                        'nazwisko' => trim($uzytkownik->nazwisko),
                        'email' => trim($uzytkownik->email),
                        'haslo' => '',
                        'potwierdzenie_hasla' => '',
                    );
        
                    $this->wczytajWidok('uzytkownicy/ustawienia', $dane);
                } else {
                    przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                }
            }
        }

        public function wyloguj() {
            unset($_SESSION['id_uzytkownika']);
            unset($_SESSION['nazwa_uzytkownika']);
            unset($_SESSION['imie']);
            unset($_SESSION['nazwisko']);
            unset($_SESSION['email']);
            session_destroy();
            przekieruj('uzytkownicy/logowanie');
            wyswietlPowiadomienie('logowanie_powiadomienie', 'Wylogowano pomyślnie. Do zobaczenia wkrótce!');
        }
    }