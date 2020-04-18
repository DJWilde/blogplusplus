<?php
    class Strony extends Kontroler {
        public function __construct() {
            // Tu zasadniczo można wczytać modele, ale dla tego kontrolera nie trzeba
        }

        // Strona główna
        public function index() {
            // Dane do przekazania do widoku
            $dane = array(
                'tytul' => 'Witaj'
            );

            // Wczytanie widoku, jeżeli istnieje
            $this->wczytajWidok('strony/index', $dane);
        }

        // Strona z pomocą
        public function pomoc() {
            // Dane do przekazania do widoku
            $dane = array(
                'tytul' => 'Pomoc'
            );

            // Wczytanie widoku, jeżeli istnieje
            $this->wczytajWidok('strony/pomoc', $dane);
        }

        // Strona zawierająca informacje np. o firmie
        public function o_nas() {
            // Dane do przekazania do widoku
            $dane = array(
                'tytul' => 'O nas'
            );

            // Wczytanie widoku, jeżeli istnieje
            $this->wczytajWidok('strony/o_nas', $dane);
        }

        // Strona z formularzem kontaktowym
        public function kontakt() {
            // Dane do przekazania do widoku
            $dane = array(
                'tytul' => 'Kontakt'
            );

            // Wczytanie widoku, jeżeli istnieje
            $this->wczytajWidok('strony/kontakt', $dane);
        }
    }