<?php

if(!isset($_SESSION['is_logged_in'])) {
        
    $_SESSION['error_msg'] = 'you need to be logged in';
    header('Location:../login.php');
    die("unauthorised");

   }

