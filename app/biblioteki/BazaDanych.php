<?php 
    class BazaDanych {
        // Dane do bazy danych
        private $host = DB_HOST;
        private $uzytkownik = DB_UZYTKOWNIK;
        private $haslo = DB_HASLO;
        private $nazwa = DB_NAZWA;

        // Obiekt bazy danych
        private $baza;
        
        // "Prepared statement"
        private $stmt;
        
        // Błędy
        private $blad;

        // Konstruktor
        public function __construct() {
            // Utworzenie linka do bazy
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->nazwa;
            // Opcje do bazy danych
            $opcje = array(
                PDO::ATTR_PERSISTENT => true,                   
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION     // Błędy zwrócone jako wyjątek
            );

            try {
                // Utworzenie połączenia z bazą danych
                $this->baza = new PDO($dsn, $this->uzytkownik, $this->haslo, $opcje);
            } catch (PDOException $ex) { // Jeżeli coś pójdzie nie tak
                $this->blad = $ex->getMessage();
                die('Błąd połączenia z bazą danych.');
            }
        }

        // Funkcja odpowiedzialna za tworzenie zapytań do bazy danych
        public function zapytanie($zapytanie) {
            $this->stmt = $this->baza->prepare($zapytanie);
        }

        // Funkcja odpowiedzialna za dowiązania parametrów do zapytań
        public function dowiaz($parametr, $wartosc, $typ = null) {
            // Sprawdzene typów danych parametrów
            if (is_null($typ)) {
                switch (true) {
                    case is_int($wartosc):
                        $typ = PDO::PARAM_INT;
                        break;
                    case is_bool($wartosc):
                        $typ = PDO::PARAM_BOOL;
                        break;
                    case is_null($wartosc):
                        $typ = PDO::PARAM_NULL;
                        break;

                    default:
                        $typ = PDO::PARAM_STR;
                }
            }
            // Dowiązanie wartości
            $this->stmt->bindValue($parametr, $wartosc, $typ);
        }

        // Wykonanie zapytania
        public function wykonaj() {
            return $this->stmt->execute();
        }

        // Zwraca zbiór wyników
        public function zbiorWynikow() {
            $this->wykonaj();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // Zwraca pojedynczy rekord
        public function pojedynczyWynik() {
            $this->wykonaj();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Zwraca liczbę wyników
        public function liczbaWynikow() {
            return $this->stmt->rowCount();
        }
    }