<?php

session_start();
require_once '../classes/Category.php';
require_once '../classes/Url.php';

$adminId = $_SESSION['admin_online'];
  echo $adminId;

$cat = new Category;


if (isset($_POST['category_btn'])) {

  $category_name = $_POST['category_name'];
  $category_type = ($_POST['category'] === 'income') ? 'income' : 'expense'; // Default to expense

   $result = $cat->addCategory($adminId, $category_name, $category_type);



  if ($result) {
    echo $_SESSION['msg'] = "Category added successfully!";
    Url::redirect('../manage_category.php');
    exit();
  } 
  else {
    echo "Error: connecting accessing post requset" ;
  }
}

?>
