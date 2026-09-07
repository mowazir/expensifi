<?php



session_start();
require '../../guard.php';
require_once '../../classes/Expense.php';
require_once '../../classes/Url.php';

$userId = $_SESSION['is_logged_in'];
  echo $userId;

$s = new Expense;

   

if (isset($_POST['btn'])) {

  $start = $_POST['expenseDate_start'];
  $end = $_POST['expenseDate_end'];
  $searchkey = $_POST['searchkey'];

  $search = $s->searchnulll($userId, $searchkey, $start, $end);
  
// Check if the user entered a search term
    if ($search) {
      require '../dp_partials/head_nav.php';
      echo " 
    <table class='table table-bordered stripe table-hover table-md'>
        <tr>
            <th>transaction_type</th>
            <th>Memo</th>
            <th>Date Incurred</th>
            <th>Amount</th>
        </tr> ";


        foreach($search as $row) {
           echo '<tr> <td><span class="badge text-bg-dark">';
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

        echo '</table>';
    }
 else{
       echo "<p>No search found.</p>";

  }
}

?>

