<?php
    /*
     * Klasa Jadro
     * Pobiera kontroler i go wczytuje na podstawie URL
     */
    class Jadro {
        protected $obecnyKontroler = 'Strony';
        protected $obecnaMetoda = 'index';
        protected $parametry = [];

        public function __construct() {
            $url = $this->pobierzURL();

            if (file_exists('../app/kontrolery/' . ucwords($url[0]) . '.php')) {
                $this->obecnyKontroler = ucwords($url[0]);

                unset($url[0]);
            }

            // Pobierz kontroler
            require_once '../app/kontrolery/' . $this->obecnyKontroler . '.php';
            $this->obecnyKontroler = new $this->obecnyKontroler;

            if (isset($url[1])) {
                if (method_exists($this->obecnyKontroler, $url[1])) {
                    $this->obecnaMetoda = $url[1];
                    unset($url[1]);
                }
            }

            $this->parametry = $url ? array_values($url) : [];

            call_user_func_array([$this->obecnyKontroler, $this->obecnaMetoda], $this->parametry);
        }

        public function pobierzURL() {
            if (isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;                
            }
        }
    }