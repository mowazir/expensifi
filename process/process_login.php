<?php
session_start();

require '../classes/User.php';
$user = new User;


if (isset($_POST['login'])) {

    
	$email = $_POST['email'];
	$password = $_POST['password'];

	if ($email == '' or $password == '' ) {
		$_SESSION['error_msg'] = 'email and password can not be empty';
		header('Location:../login.php'); 
		exit();
	}

	$rsp = $user->login_user($email, $password);

	if ($rsp) {
		
		$_SESSION['msg'] = 'You are logged in';
		header('Location:../dashboard/index.php');
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
