<?php
    /*
     * Klasa bazowa Kontroler
     * Odpowiada za wczytywanie modeli i widoków
     */
    
    class Kontroler {
        // Wczytanie modeli
        public function wczytajModel($model) {
            require_once '../app/modele/' . $model . '.php';

            return new $model();
        }

        // Wczytanie widoku
        public function wczytajWidok($widok, $dane = []) {
            if (file_exists('../app/widoki/' . $widok . '.php')) {
                require_once '../app/widoki/' . $widok . '.php';
            } else {
                die('Widok nie istnieje.');
            }
        }
    }