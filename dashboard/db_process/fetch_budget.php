<?php
session_start();
require '../../guard.php';
require_once '../../classes/Category.php';
require_once("../../classes/BudgetReport.php");
require_once '../../classes/Budget.php';
require_once '../../classes/Expense.php';

$user_id = $_SESSION['is_logged_in'];

$gc = new Category;
    // Fetch budget and expenses
$budgetClass = new Budget;
 $expenseClass = new Expense;

    // Generate report
// $report = new BudgetReport($totalBudget, $totalExpenses);


//option 3 using ajax
if (isset($_POST['btn'])) {


$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$totalBudget = $budgetClass->getTotal($user_id, $start_date, $end_date);

$totalExpenses = $expenseClass->getTotal($user_id, $start_date, $end_date);

 $report = new BudgetReport($totalBudget, $totalExpenses);

   if ($report){

     echo  
        "<div class='card-footer bg-light'>
                 <ul class='list-group'>
                    <li class='list-group-item'>Your Total Budget: <strong>".
                    number_format($report->budget,2).
                    "</strong></li>
                    <li class='list-group-item>Your Total Expenses: <strong>".
                    number_format($report->expenses,2). " </strong></li>
                   <li class='list-group-item'>All spendings: <strong>".
                   number_format($report->difference,2). 
                   " </strong></li>
                   <li class='list-group-item'>Budget Health Status: <strong>".$report->message . "</strong></li>
                 </ul>
               </div>";

         } else{
            echo 'Error comparing budget, pls try again';
         }

}

else {
    header('location:../index.php');
    exit;
}
