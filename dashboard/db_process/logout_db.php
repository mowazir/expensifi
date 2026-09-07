<?php
session_start();
require '../../guard.php';
require '../../classes/User.php';
$logout = new User;

$logout->logout();

header('Location:../../login.php');
exit();




?>