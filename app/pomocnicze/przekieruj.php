<?php
    function przekieruj($url) {
        header('location: ' . URL_GLOWNE . '/' . $url);
    }