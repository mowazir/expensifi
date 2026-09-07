<?php

class Url
{

    public static function redirect($path)
    {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTP'] != 'off' ) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        
        header("Location: $path" );
        exit;

    }

}