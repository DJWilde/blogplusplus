<?php 
    class BazaDanych {
        // Dane do bazy danych
        private $host = DB_HOST;
        private $uzytkownik = DB_UZYTKOWNIK;
        private $haslo = DB_HASLO;
        private $nazwa = DB_NAZWA;

        // Obiekt bazy danych
        private $baza;
        
        // Prepared statement
        private $stmt;
        
        // Błędy
        private $blad;

        public function __construct() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->nazwa;
            $opcje = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->baza = new PDO($dsn, $this->uzytkownik, $this->haslo, $opcje);
            } catch (PDOException $ex) {
                $this->blad = $ex->getMessage();
                die('Błąd połączenia z bazą danych.');
            }
        }

        public function zapytanie($zapytanie) {
            $this->stmt = $this->baza->prepare($zapytanie);
        }

        public function dowiaz($parametr, $wartosc, $typ = null) {
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
            $this->stmt->bindValue($parametr, $wartosc, $typ);
        }

        public function wykonaj() {
            return $this->stmt->execute();
        }

        public function zbiorWynikow() {
            $this->wykonaj();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function pojedynczyWynik() {
            $this->wykonaj();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function liczbaWynikow() {
            return $this->stmt->rowCount();
        }
    }