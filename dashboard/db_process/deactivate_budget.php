<?php
session_start();
require '../../guard.php';
require '../../classes/Url.php';
require '../../classes/User.php';
require '../../classes/Budget.php';


$user_id = $_SESSION['is_logged_in'];

$bud = new Budget;


if (isset($_GET['bid'])) {

	$bid = $_GET['bid']; //get budget id
	
	if ($bud->toggle_budget($bid)) {
		$_SESSION['msg'] = " budget updated ";
		
	} else{
		$_SESSION['error_msg'] = 'error activating budget';
	
	}

	Url::redirect('../budget_compare.php');


}

// if ($bud->toggle_budget($bid)) {

// 	$_SESSION['msg'] = " budget updated ";

// } else {
// 	echo 'error activating budget';
// }
// Url::redirect('../budget_compare.php');





?>