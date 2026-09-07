<?php
session_start();

require '../classes/Admin.php';
$user = new Admin;

if (isset($_POST['adminlog'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if ($username == '' or $password == '' ) {
		$_SESSION['error_msg'] = 'fullname, username and password can not be empty';
		header('Location:../login.php'); 
		exit();
	}

	$rsp = $user->login_admin($username, $password);

	if ($rsp) {
		
		$_SESSION['msg'] = 'You are logged in';
		header('Location:../index.php');
		exit();

	} else{

		header('Location:../login.php');
		exit();

	}


} 


else {
	$_SESSION['error_msg'] = "Oopsies! Sorry, You have to complete the form";
 	header('Location:../login.php');
 	exit();
}

?>
