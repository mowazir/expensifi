<?php 
session_start();

require '../guard.php';
require '../classes/User.php';
require_once '../classes/Expense.php';
require_once '../classes/BudgetReport.php';
require_once '../classes/Paginate.php';

$user_online = $_SESSION['is_logged_in'];

$expense = new Expense;

$yesterdate=date('Y-m-d',strtotime("-1 days")); //yesterday
$monthdate=  date("Y-m-d", strtotime("-1 month"));  //1month
$currentdate = date('Y-m-d');

$todayExpense = $expense->getTotal($user_online, $currentdate, $currentdate);
$yesterExpenses = $expense->getTotal($user_online, $yesterdate, $currentdate);
$monthlyExpenses = $expense->getTotal($user_online, $monthdate, $currentdate);
$allExpense = $expense->totalExpenses($user_online);


$user = new User;
$user_details = $user->get_user_details($user_online);

$totalRecord = $expense->getTotalRecords();

$paginator = new Paginator($_GET['page'] ?? 1, 6, $totalRecord);

$transactions = $expense->getTransactions( $paginator->limit, $paginator->offset);
require 'dp_partials/head_nav.php';

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Expensify</title>

    <!-- end nav -->
         <div class="container">
        <div class="container-fluid" >


            <div class="row">
            <div class="col-md-10">

        <section class=" py-5 content-card">
        <div class="container text-center">        
                <?php if(isset($user_details['name'])) { ?>

            <h3 class="welcome text text-secondary">Welcome back, <?= $user_details['name'] ?>. <br> What are you spending on today? </h3>
             
                <?php } ?>
        
                </div>
             </section>
            </div>
            </div>


 <div class="container">
     <div class="row mb-10">
             <div class="col-md-3 col-lg-3">
              <div class="card shadow-sm">
                <div class="me-3 card-body d-flex justify-content-around">
                  <div class=" bg-warning text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                    <i class="fa-regular fa-circle-dot"></i>
                </div>
                  <div>
                <p class="fw-bold">₦<?= number_format($todayExpense, 2) ?> </p>
                    <span class="text text-info">As of Today</span>
                  </div>
                </div>
              </div>
            </div>

             <div class="col-md-3 col-lg-3">
              <div class="card shadow-sm">
                <div class="me-3 card-body d-flex justify-content-around">
                  <div class=" bg-warning text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                    <i class="fa-regular fa-circle-up"></i>
                  </div>
                  <div>

                    <p class="fw-bold"> ₦<?= number_format($yesterExpenses, 2) ?> </p>
                    <span class="text text-primary">Up from yesterday</span>
                  </div>
                </div>
              </div>
            </div>

      <div class="col-md-3 col-lg-3">
              <div class="card shadow-sm">
                <div class="me-3 card-body d-flex justify-content-around">
                  <div class=" bg-warning text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                    <i class="fa-regular fa-circle-down"></i>
                  </div>
                  <div>
                   
                    <p class="fw-bold"> ₦ <?= number_format($monthlyExpenses, 2) ?> </p>
                    <span class="text text-secondary">Up from Last 30 day</span>
                  </div>
                </div>
              </div>
            </div>

           

            <div class="col-md-3 col-lg-3 mb-4">
              <div class="card shadow-sm">
                <div class="me-3 card-body d-flex justify-content-around">
                  <div class=" bg-warning text-white rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                   <i class="fa-regular fa-chart-bar"></i>
                  </div>
                  <div>

                    <p class="fw-bold"> ₦<?= number_format($allExpense, 2) ?> </p>
                    <span class="mb-0 text-success">Total Expense</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>

        <div class="col-md-6 d-flex justify-content-around">
        <form class="form-control">

            <label for="modal-category" class="form-label">It's a great day today!</label> <br> <br>
            
            <span class=""> <a href="add_expense.php" class="btn btn-dark rounded"> Add Expense </a> </span> 
            <span class=""> <a href="add_budget.php" class="btn btn-info rounded"> Add Budget </a> </span>

        </form>              

         </div>
         </div>
           
            </div>

            <div class="container ">
                <div class="row">
              
                <div class="col-md-12">

                    <?php require '../partials/msg.php'  ?>
                   
                    <div class="table-container">
                        <table class="table table-bordered stripe table-hover table-md">
                            <thead>
                                <tr>
                                    
                                     <th scope="col">Description</th>
                                    <th scope="col">ِAmount</th>
                                   
                                    <th scope="col">Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="">
                        
                    <?php 
                        if (count($transactions) > 0) {
                            foreach($transactions as $transaction) { ?>
                                <tr>
                               
                               <td><?= ucwords($transaction['memo'] ) ?></td>
                                <td> <?php if($transaction['amount'] > 2000)  { ?>
                                    <span class="badge bg-success">₦ <?=$transaction['amount'] ?></span> 
                             <?php } else { ?>
                                    <span class="badge bg-info">₦ <?=$transaction['amount'] ?></span> 
                             <?php } ?>

                                </td>

                                <td>
                              <?php if($transaction['transaction_type'] == 'income') { ?>
                                <span class="badge bg-success">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
      
                             <?php }elseif($transaction['transaction_type'] == 'transfer'){ ?>
                                    <span class="badge bg-danger">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
                            <?php }else{ ?>
                                     <span class="badge bg-info">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
                            <?php } ?>
                        
                                  </td>
                                  <td> <span class="badge bg-dark"><?=$transaction['date_incurred'] ?></span> </td>
                
                                  <td class="text-center d-flex">
                                        
                                 <!-- <form action="db_process/delete_transaction.php" method="get">
                                    <button class="btn btn-sm-7" type="submit" name="btn">
                                    <i class="fas fa-trash"></i> 
                                    <a class="btn btn-warning " href="db_process/delete_transaction.php?catid=
                                    <//?= //$transaction['transaction_id'] ?>" name ='delete'>Delete Category</a>

                                  </button>
                                 </form> -->
                                      
                                    </td>
                                </tr>

                       <?php 
                        } ?> 
                    <?php } else {
                            echo "<tr><td colspan = '4'> Oopsies! You haven\'nt create any expense yet. <a href='add_expense.php' class='btn btn-secondary'>Click here to create one</a> </td></tr>";
                       } ?>

                            </tbody>
                        </table>
                    </div>
                </div>


    <?php require 'dp_partials/paginator.php'; ?>
        
        
     

                </div>
            </div>

        </div>
    </div>



       <script src="../assets//bootstrap/js/bootstrap.bundle.js"> </script>
    <!-- Script JS -->

    <script src="../assets/jquery/jquery.min.js"></script>
</body>
</html>
