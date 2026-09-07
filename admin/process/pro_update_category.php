<?php

session_start();

require '../classes/Category.php';

if (isset($_POST['editcat'])) {
	
	$catid = $_POST['catid'];
	$category_name = $_POST['category_name'];
	$category_type = ($_POST['category'] === 'income') ?
	 'income' : 'expense' ;

	$update = new Category;

	$category_edit = $update->updateCategory($catid, $category_name, $category_type);

	if ($category_edit) {
		//it means the profile was updated, keep success msg
		$_SESSION['msg'] = 'Category updated successuflly';
		header('Location:../manage_category.php'); exit();	
			} else {
			//Category was not updated, keep error in session
			$_SESSION['error_msg'] = 'unable to update Category';
			header('Location:../update_category.php');
			exit();
		}

		//send them back
		header('Location:../index.php');
		exit();		
}
 

else {
	header('Location:../.php', 'error');
		exit();

}




?>
