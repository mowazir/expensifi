<?php

        
    if(!isset($_SESSION['admin_online'])) {
        
    $_SESSION['error_msg'] = 'you need to be logged in';
    header('Location:login.php');
    die("unauthorised");

   }

?>