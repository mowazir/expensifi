<?php

require 'config.php';

class Db
{

    protected function connect()
    {
        try {

            $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $conn = new PDO($dsn, DBUSER, DBPASS, $options);
            return $conn;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    

}
