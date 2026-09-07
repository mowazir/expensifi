<?php
session_start();

require '../classes/User.php';
$user = new User;


if (isset($_POST['btn_reg']) ) {

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if ($username == '' or $email == '' or $password == '' ) {
		$_SESSION['error_msg'] = 'username, email and password can not be empty';
		header('Location:../register.php'); 
		exit();
	}

	if($password !== $confirm_password ) {
		$_SESSION['error_msg'] = 'sorry, password must match';
		header('Location:../register.php'); 
		exit();
	}


	$rsp = $user->register_user($username, $email, $password);
	echo $rsp;


	if ($rsp) {
		
		$_SESSION['msg'] = 'An account has been created for you';
		header('Location:../login.php');
		exit();

	} else{
		$_SESSION['error_msg'] = 'Oopsies! something happened when creating account';
		header('Location:../register.php');
		exit();

	}


} 


else {
	$_SESSION['error_msg'] = "Oopsies! Sorry, You have to complete the form";
 	header('Location:../register.php');
 	exit();
}

?>
