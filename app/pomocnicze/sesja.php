<?php
    session_start();

    function wyswietlPowiadomienie($nazwa = '', $powiadomienie = '', $klasa = 'alert alert-success') {
        if (!empty($nazwa)) {
            if (!empty($powiadomienie) && empty($_SESSION[$nazwa])) {
                if (!empty($_SESSION[$nazwa])) {
                    unset($_SESSION[$nazwa]);
                }
                if (!empty($_SESSION[$nazwa . '_class'])) {
                    unset($_SESSION[$nazwa . '_class']);
                }

                $_SESSION[$nazwa] = $powiadomienie;
                $_SESSION[$nazwa . '_class'] = $klasa;
            } else if (empty($powiadomienie) && !empty($_SESSION[$nazwa])) {
                $klasa = !empty($_SESSION[$nazwa . '_class']) ? $_SESSION[$nazwa . '_class'] : '';
                echo '<div class="' . $klasa . '" id="powiadomienie">' . $_SESSION[$nazwa] . '</div>';
                unset($_SESSION[$nazwa]);
                unset($_SESSION[$nazwa . '_class']);
            }
        }
    }

    function czyZalogowany() {
        if (isset($_SESSION['id_uzytkownika'])) {
            return true;
        } else {
            return false;
        }
    }