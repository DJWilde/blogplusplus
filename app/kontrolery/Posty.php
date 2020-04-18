<?php
    class Posty extends Kontroler {
        public function __construct() {
            // Wczytanie modeli
            $this->modelPostu = $this->wczytajModel('Post');
            $this->modelUzytkownika = $this->wczytajModel('Uzytkownik');
        }

        // Dodanie posta
        public function dodaj() {
            if (!czyZalogowany()) {
                wyswietlPowiadomienie('logowanie_powiadomienie', 'Ta strona wymaga zalogowania. Zaloguj się poniżej.', 
                                        'alert alert-warning');
                przekieruj('uzytkownicy/logowanie');
            }
            // Sprawdź czy żądanie jest POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!empty($_POST['token_csrf'])) {
                    if (sprawdzToken($_POST['token_csrf'], 'formularz_dodanie_postow')) {
                        // Kroki:
                        // 1. Oczyścić tablice $_POST
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        // 2. Zadeklarować i oczyścić dane
                        $dane = array(
                            'tytul' => trim($_POST['tytul']),
                            'tekst' => trim($_POST['tekst']),
                            'id_uzytkownika' => $_SESSION['id_uzytkownika'],
                            'blad_tytul' => '',
                            'blad_tekst' => '',
                        );

                        // 3. Walidacja e-maila i sprawdzenie czy użytkownik o danym adresie e-mail istnieje
                        if (empty($dane['tytul'])) {
                            $dane['blad_tytul'] = 'Wypełnij to pole.';
                        } 

                        // 4. Sprawdzenie obecności hasła i ich długości
                        if (empty($dane['tekst'])) {
                            $dane['blad_tekst'] = 'Wypełnij to pole.';
                        }
                        
                        // 5. Sprawdź czy nie ma błędów
                        if (empty($dane['blad_tytul']) && empty($dane['blad_tekst'])) {
                            if ($this->modelPostu->utworzPost($dane)) {
                                wyswietlPowiadomienie('uzytkownicy_powiadomienie', 'Post został utworzony pomyślnie.');
                                przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                            } else {
                                die('Coś poszło nie tak...');
                            }
                        } else {
                            // 6. Jeżeli wystąpiły błędy to wyświetl je użytkownikowi z formularzem.
                            wyswietlPowiadomienie('posty_powiadomienie', 'W Twoim formularzu wystąpiły błędy.', 'alert alert-danger');
                            $this->wczytajWidok('posty/dodaj', $dane);
                        }
                    } else { // Próba weryfikacji tokenu nie powiodła się
                        die('Weryfikacja tokenu zakończyła się niepowodzeniem.');
                    }
                } else {
                    die('Token jest pusty.');
                }
            } else { // Gdy mamy żądanie GET
                $dane = array(
                    'tytul' => '',
                    'tekst' => '',
                );

                // Wyświetl pusty formularz
                $this->wczytajWidok('posty/dodaj', $dane);
            }
        }

        // Edycja posta
        public function edytuj($id) {
            if (!czyZalogowany()) {
                wyswietlPowiadomienie('logowanie_powiadomienie', 'Ta strona wymaga zalogowania. Zaloguj się poniżej.', 
                                        'alert alert-warning');
                przekieruj('uzytkownicy/logowanie');
            }
            // Sprawdź czy żądanie jest POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!empty($_POST['token_csrf'])) {
                    if (sprawdzToken($_POST['token_csrf'], 'formularz_edycja_postow')) {
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                        $dane = array(
                            'id' => $id,
                            'tytul' => trim($_POST['tytul']),
                            'tekst' => trim($_POST['tekst']),
                            'id_uzytkownika' => $_SESSION['id_uzytkownika'],
                            'blad_tytul' => '',
                            'blad_tekst' => ''
                        );

                        // Walidacja tytułu
                        if (empty($dane['tytul'])) {
                            $data['blad_tytul'] = 'Wypełnij to pole.';
                        }

                        // Walidacja tekstu
                        if (empty($dane['tekst'])) {
                            $data['blad_tekst'] = 'Wypełnij to pole.';
                        }

                        if (empty($dane['blad_tytul']) && empty($dane['blad_tekst'])) {
                            if ($this->modelPostu->aktualizujPost($dane)) {
                                wyswietlPowiadomienie('uzytkownik_powiadomienie', 'Post został zaktualizowany pomyślnie.');
                                przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                            } else {
                                die('Coś poszło nie tak...');
                            }
                        } else {
                            wyswietlPowiadomienie('posty_powiadomienie', 'W Twoim formularzu wystąpiły błędy.', 'alert alert-danger');
                            $this->wczytajWidok('posty/edytuj', $dane);
                        }
                    } else { // Próba weryfikacji tokenu nie powiodła się
                        die('Weryfikacja tokenu zakończyła się niepowodzeniem.');
                    }
                } else {
                    die('Token jest pusty.');
                }
            } else {
                $post = $this->modelPostu->pokazPost($id);

                if ($post->id_uzytkownika !== $_SESSION['id_uzytkownika']) {
                    redirect('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                } 

                $dane = array(
                    'id' => $id,
                    'tytul' => trim($post->tytul),
                    'tekst' => trim($post->tekst)
                );

                $this->wczytajWidok('posty/edytuj', $dane);
            }
        }

        // Pokazanie posta
        public function post($id) {
            $post = $this->modelPostu->pokazPost($id);
            $uzytkownik = $this->modelUzytkownika->pobierzUzytkownikaPoId($post->id_uzytkownika);

            $dane = array(
                'post' => $post,
                'uzytkownik' => $uzytkownik
            );

            $this->wczytajWidok('posty/post', $dane);
        }

        // Usuwanie posta
        public function usun($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!empty($_POST['token_csrf'])) {
                    if (sprawdzToken($_POST['token_csrf'], 'formularz_usuniecia_postu')) {
                        $post = $this->modelPostu->pokazPost($id);

                        if ($post->id_uzytkownika !== $_SESSION['id_uzytkownika']) {
                            redirect('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                        }

                        if ($this->modelPostu->usunPost($id)) {
                            wyswietlPowiadomienie('uzytkownik_powiadomienie', 'Post został usunięty pomyślnie.');
                            przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
                        } else {
                            die('Coś poszło nie tak...');
                        }
                    } else {// Próba weryfikacji tokenu nie powiodła się
                        die('Weryfikacja tokenu zakończyła się niepowodzeniem.');
                    }
                } else {
                    die('Token jest pusty.');
                }
            } else {
                przekieruj('uzytkownicy/panel_glowny/' . $_SESSION['id_uzytkownika']);
            }
        }
    }