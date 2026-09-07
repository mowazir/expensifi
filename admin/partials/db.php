<?php
require_once 'classes/config.php';
require_once 'classes/Db.php';


$db = new Database(DBSERVER, DBNAME, DBUSER, DBPASS);
return $db->getConn();
