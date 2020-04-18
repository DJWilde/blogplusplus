<?php
    /*
     * Klasa Jadro
     * Pobiera kontroler i go wczytuje na podstawie URL
     * Format URL: /<nazwa_kontrolera>/<nazwa_czynnosci>/<parametry>
     */
    class Jadro {
        // Pola przechowywujące informacje o kontrolerze, metodzie i opcjonalnych parametrach (np. ID)
        protected $obecnyKontroler = 'Strony';
        protected $obecnaMetoda = 'index';
        protected $parametry = [];

        // Konstruktor
        public function __construct() {
            $url = $this->pobierzURL();

            // Poprawka do PHP 7.4 (krzyczało że próbowano uzyskać dostęp do indeksu nieistniejącej tablicy)
            if (isset($url[0])) {
                // Sprawdzenie czy dany kontroler istnieje, jeżeli tak to ustaw kontroler na ten kontroler
                if (file_exists('../app/kontrolery/' . ucwords($url[0]) . '.php')) {
                    $this->obecnyKontroler = ucwords($url[0]);
                    // Wyczyść część kontrolera z URL
                    unset($url[0]);
                }
            }

            // Pobierz kontroler i utwórz instancję kontrolera
            require_once '../app/kontrolery/' . $this->obecnyKontroler . '.php';
            $this->obecnyKontroler = new $this->obecnyKontroler;

            // Sprawdzenie czy dana metoda istnieje, jeżeli tak to ustaw metodę na daną metodę
            if (isset($url[1])) {
                if (method_exists($this->obecnyKontroler, $url[1])) {
                    $this->obecnaMetoda = $url[1];
                    unset($url[1]);
                }
            }

            // Dołącz jakiekolwiek parametry
            $this->parametry = $url ? array_values($url) : [];

            // Uruchom funkcję callback wraz z parametrami
            call_user_func_array([$this->obecnyKontroler, $this->obecnaMetoda], $this->parametry);
        }

        public function pobierzURL() {
            // Sprawdź czy URL jest
            if (isset($_GET['url'])) {
                // Sprawdzenie czy URL jest właściwy, jeżeli tak to rozdziel URL na poszczególne elementy, a potem zwróć URL 
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;                
            }
        }
    }