<?php 
session_start();

require_once '../guard.php';
require_once '../classes/User.php';
require_once '../classes/Budget.php';

$user_id = $_SESSION['is_logged_in'];

$allbudget = new Budget;

$budgets = $allbudget->getBudget();

require_once 'dp_partials/head_nav.php';


 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Budget </title>
   
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">💸Yikes! Let's compare your budget </h4>

        </div>
        <div class="card-body">
            <form method="POST" action="db_process/process_compare_budget.php">
                <div class="row mb-3">

                    <p class="text text-right me-4"><a href="add_budget.php" class="btn btn-outline-success text-center">Add Budget</a></p>
                    
                    <div class="col-md-4">
                        <label class="form-label">From: </label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required >
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">To: </label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required value="<?= date('Y-m-d'); ?>" >
                    </div>
                </div>
                <button type="submit" id ='compare' class="btn btn-success">Compare</button>
            </form>
        </div>

 
        <div class='card-footer bg-light'>
                 <ul class='list-group' id="categories">
                   
                 </ul>
               </div>

    </div>
</div>

<div class="container ">
                <div class="row">
              
                <div class="col-md-12">

            <?php  require_once '../partials/msg.php'; ?>
                   
                    <div class="table-container">
                        <table class="table text-center table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Budget Name</th>
                                    <th scope="col">Budget Amount</th>
                                    <th scope="col">Budget Duration</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                              <tbody id="">
                        
                    <?php 
                        if (count($budgets) > 0) {
                            foreach($budgets as $budget) { ?>
                                <tr>
                               
                               <td><?= ucwords($budget['budget_name'] ) ?>
                               </td>

                                <td>  
                                <span class="badge badge-pill text-bg-primary "> 
                                ₦ <?= $budget['amount_limit'] ?>
                                   
                                </span> 
                                </td>

                                <td>
                              <?php if($budget['period_type'] == 'monthly') { ?>
                                <span class="badge text-bg-info">
                                    <?=$budget['period_type'] ?>  
                                  </span>
                                <?php }else{ ?>
                                    <span class="badge text-bg-danger">
                            <?php } ?>
                        
                                  </td>
                                  <td> <span class="badge text-bg-dark"><?=$budget['start_date'] ?></span> </td>
                                  <td> <span class="badge text-bg-danger"><?=$budget['end_date'] ?></span> </td>
                
                                  <td class="text-center d-flex">
                                        
                                 <form action="db_process/deactivate_budget.php" method="get">
                                    <button class="btn btn-warning" type="submit" name="btn">
                                    <i class="fas fa-trash"></i> 
                                    <a class="btn btn-sm" href="db_process/deactivate_budget.php?bid=<?=$budget['budget_id'] ?>" name ='delete'>Update Budget</a> </button>

                                    <td>
                            <?php if($budget['is_active'] == 'yes') { ?>
                                 <i class="fa-solid fa-star" ></i>Active
                            <?php } else{  ?>
                                <i class="fa-regular fa-star" ></i>Inactive
                          </td>
                        <?php } ?>

                                  
                                 </form>
                                      
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
            

                </div>
            </div>



   <script src="../assets//bootstrap/js/bootstrap.bundle.js"> </script>
    <script src="../assets/jquery/jquery.min.js"></script>

    <script>

        $(document).ready(function(){

       $("#compare").click(function(){
        event.preventDefault();

        let compare = $('#compare').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();

         var budget_id = {
            compare,
            start_date,
            end_date,
            btn : true
            };
            
        //ajax
        $.ajax({
            url : "db_process/fetch_budget.php",
            type : "post",
            data : budget_id,
            dataType : "text",
            success : function(data){
              //  console.log(data);
                let categories = $('#categories').html(data);
                
            },
            error : function(error) {
                console.log(error);
             } 
        });

    });


        })

    </script>

</body>
</html>



  