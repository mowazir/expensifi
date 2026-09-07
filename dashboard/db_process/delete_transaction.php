<?php
session_start();
require '../../guard.php';
require '../../classes/Url.php';

require_once '../../classes/Expense.php';
require '../../classes/User.php';


$user_id = $_SESSION['is_logged_in'];

$del = new Expense;

$delid = $_GET['catid'];

if ($del->deleteCategory($user_id, $delid)) {

	$_SESSION['msg'] = " transaction deleted ";

} else {
	echo 'error deleting transaction';
}
Url::redirect('../index.php');





?>