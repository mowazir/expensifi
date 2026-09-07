<?php

session_start();

require '../../classes/User.php';

if (isset($_POST['profileupdate'])) {
	
	$name = $_POST['name'];
	$bio = $_POST['bio'];

	$user_id = $_SESSION['is_logged_in'];

	$update = new User;
	$profile = $update->update_profile($name, $bio, $user_id);

	if ($profile) {
		//it means the profile was updated, keep success msg
		$_SESSION['msg'] = 'Profile updated successuflly';
			} else {
			//profile was not updated, keep error in session
			$_SESSION['error_msg'] = 'unable to update Profile';
		}

		//send them back
		header('Location:../profile.php');
		exit();		
}
 

else {
	echo "na, go back to staircase";
}




?>
