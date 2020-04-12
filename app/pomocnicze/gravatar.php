<?php
    function gravatar($email, $rozmiar = 200, $format = 'mp', $rating = 'g', $obraz = false, $atrybuty = array()) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$rozmiar&d=$format&r=$obraz";
        if ( $obraz ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atrybuty as $klucz => $wartosc )
                $url .= ' ' . $klucz . '="' . $wartosc . '"';
            $url .= ' />';
        }
        return $url;
    }