<?php
session_start();
require '../../guard.php';
require_once '../../classes/Category.php';

$userid = $_SESSION['is_logged_in'];

$gc = new Category;


//option 3 using ajax
if (isset($_POST['btn'])) {

    $caty_id = $_POST['category']; //category type

    $getCategories = $gc->fetchCategoriesByType($userid, $caty_id);

    foreach($getCategories as $category ){
       $value = $category['category_id'] ;
       $cat_type = $gc->check_category_status($caty_id);

       if ($caty_id == 'expense') {
        echo "<option value='$value'> "
        .$category['category_name'].
        " </option>"; 

    } elseif($caty_id == 'income') {
        echo "<option value='$value'> "
        .$category['category_name'].
        " </option>";        
     }

    }

}

else {
    header('location:../add_expense.php');
    exit;
}
