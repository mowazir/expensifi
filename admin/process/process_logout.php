<?php
session_start();

require '../classes/Admin.php';
$logout = new Admin;

$logout->logout();

header('Location:../login.php');
exit();




?>
