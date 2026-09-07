<?php

session_start();
require '../../guard.php';
require_once '../../classes/Budget.php';
require_once '../../classes/Url.php';

$user_id = $_SESSION['is_logged_in'];
  echo $user_id;

$budget = new Budget;

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['budgetbtn'])) {
    
    $budget_name = $_POST[ 'budget_name'];
    $amount_limit = $_POST[ 'amount_limit'];
    #$period_type = $_POST['period_type'] ?? '';
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date = trim($_POST['end_date'] ?? '');

    $category_id = $_POST['category_id'];
    
    $period_type = ($_POST['period_type'] === 'monthly') ? 'monthly' : 'weekly';
    //var_dump($_POST); 

    // 2. Validation
    if (empty($budget_name)) {
       $errors[] = "Sorry! Budget Name is required."; 
      }
    if (empty($category_id)) { 
      $errors[] = "Please select a Category .";
       }
    if ($amount_limit <= 0) {
      $errors[] = "Amount must be greater than zero."; 
      }
    if ($period_type == '') { 
      $errors[] = "Invalid period type. please try again"; 
    }

    if (empty($formData['start_date']) || empty($formData['end_date']) || $formData['start_date'] > $formData['end_date']) { 
        $errors[] = "Valid start and end dates are required."; 
    }

    // 3. Save
    $res = $budget->createBudget($user_id, $category_id, $budget_name, $amount_limit, $period_type, $start_date, $end_date);
    if ($res) {
          Url::redirect('../budget_compare.php');
          exit();
        } else {
           Url::redirect('../add_budget.php');
          exit();
          echo 'error saving';
            $_SESSION['error_msg'] = "Budget Saving Error: ";
        }
  
}
