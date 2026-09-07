<?php

session_start();
require '../../guard.php';
require_once '../../classes/Expense.php';
require_once '../../classes/Url.php';

$userId = $_SESSION['is_logged_in'];

 $search_res = new Expense;


//option 3 using ajax
if (isset($_POST['btn'])) {

   $start_date = $_POST['start_date'];
   $end_date = $_POST['end_date'];

  $searchkey = $_POST['searchkey'];

  $search = $search_res->searchnulll($userId, $searchkey, $start_date, $end_date);

    if ($search) {
     # require '../dp_partials/head_nav.php';
      echo " 
    <table class='table table-bordered stripe table-hover table-md'>
        <tr>
            <th>transaction_type</th>
            <th>Memo</th>
            <th>Date Incurred</th>
            <th>Amount</th>
        </tr> ";


        foreach($search as $row) {
           echo '<tr> <td><span class="badge text-bg-secondary">';
           echo htmlspecialchars($row['transaction_type']) ;
           echo '</td> <td> </span>';
          echo htmlspecialchars($row['memo']) ;
            echo "</td>
                <td> <span class='badge text-bg-dark'>";
            echo htmlspecialchars($row['date_incurred']);
            echo "</td> <td> </span>";
            echo htmlspecialchars($row['amount']);
            echo "</td>
            </tr>";

            }

         
    }  else{
       echo "<p>No search found.</p>";
  }

}

else {
    header('location:../index.php');
    exit;
}
