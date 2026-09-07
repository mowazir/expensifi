<?php

session_start();
require '../../guard.php';
require_once '../../classes/Category.php';
require_once '../../classes/Url.php';

$userId = $_SESSION['is_logged_in'];
  echo $userId;

$cat = new Category;


if (isset($_POST['category_btn'])) {

  $category_name = $_POST['category_name'];
  $category_type = ($_POST['category'] === 'income') ? 'income' : 'expense'; // Default to expense

   $result = $cat->addCategory($userId, $category_name, $category_type);



  if ($result) {
    echo $_SESSION['msg'] = "Category added successfully!";
    if ($category_type === 'expense') {
      Url::redirect('../add_expense.php');
    } else {
      Url::redirect('../add_income.php');
    }
    exit();
  } 
  else {
    echo "Error: connecting accessing post requset" ;
  }
}

?>
