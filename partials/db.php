<?php
require_once 'classes/config.php';
require_once 'classes/Db.php';


$db = new Db(DBSERVER, DBNAME, DBUSER, DBPASS);
return $db->connect();
