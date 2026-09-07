<?php

session_start();
require '../../guard.php';
require_once '../../classes/Url.php';
require_once '../../classes/Budget.php';
require_once '../../classes/Expense.php';
require_once '../../classes/BudgetReport.php';

$user_id = $_SESSION['is_logged_in'];
$report = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch budget and expenses
    $budgetClass = new Budget;
    $expenseClass = new Expense;

  

    $totalBudget = $budgetClass->getTotal($user_id, $start_date, $end_date);

    $totalExpenses = $expenseClass->getTotal($user_id, $start_date, $end_date);

    // Generate report
    $report = new BudgetReport($totalBudget, $totalExpenses);

     if ($report){
     		Url::redirect('../budget_compare.php');
         } else{
         	echo 'Error comparing budget, pls try again';
         }
}




