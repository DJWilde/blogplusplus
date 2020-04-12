<?php
    function przekieruj($url) {
        header('location: ' . URL_GLOWNE . '/' . $url);
    }

    function czyDanyUzytkownik($id) {
        if ($id === $_SESSION['id_uzytkownika']) {
            return true;
        } else {
            return false;
        }
    }