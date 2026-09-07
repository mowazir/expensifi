<?php
session_start();
require '../../guard.php';
require_once '../../classes/Url.php';
require '../../classes/User.php';
require '../../classes/Expense.php';

$tm = new Expense;

$user_id = $_SESSION['is_logged_in'];

$errors = [];
$success = '';


$data = $_POST ?? [];

echo $user_id;
#echo ' user id from process ends here<br>';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expensebtn'])) {

    $data = [
        'userId' => $user_id,
        'type' => $_POST['transaction_type'] ?? '',
        'amount' => filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT),
        'account_id' => filter_input(INPUT_POST, 'account_id', FILTER_VALIDATE_INT),
        'destination_account_id' => filter_input(INPUT_POST, 'destination_account_id', FILTER_VALIDATE_INT),
     
        'category_id' => filter_input(INPUT_POST, 'categories', FILTER_VALIDATE_INT) ?: null, 
        'date_incurred' => trim($_POST['date_incurred'] ?? ''),
        'memo' => filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_SPECIAL_CHARS),
    ];
    
    extract($data);
   

    if (!in_array($type, ['expense', 'income', 'transfer'])) { 
        $errors[] = "Invalid transaction type selected.";
    }

    // Check if $amount is invalid OR if it's zero.
    if (!$amount || $amount <= 0) {  
        $errors[] = "Amount must be a positive number.";
    }
    
    if (!$account_id) {
       $errors[] = "Please select an account."; 
    }
    //confirm type here
    if ($type === 'transfer') {
        if (!$destination_account_id) {
             $errors[] = "Please select a destination account for the transfer.";
        } else if ($account_id == $destination_account_id) {
             $errors[] = "Source and Destination accounts must be different for a transfer.";
        }
        $data['category_id'] = null; 

    } else { // Income or Expense
        if (!$category_id) {
             $errors[] = "Please select a category.";
        }
    }


    if (empty($errors)) {
       var_dump($data);
          echo $_SESSION['msg'] = "Category added successfully!";
            $tm->addTransaction($data);
            $success = "Transaction recorded successfully!";
          
            $_POST = []; 
            Url::redirect('../index.php'); 
       
            #echo
            $errors[] = "Transaction Error: ";
        
    } else{
        var_dump( $errors ) ; 
    }
}

else {
  echo 'error accessing files <a href="../add_expense.php">home</a>';
  exit();
}
