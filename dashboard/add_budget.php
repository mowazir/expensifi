<?php
session_start();

require_once '../guard.php';
require_once '../classes/User.php';

require_once("../classes/Category.php");

$user_id = $_SESSION['is_logged_in'];

 $c = new Category;
$accounts = $c->fetchAccounts($user_id);

$user = new User;
$user_details = $user->get_user_details($user_id);

//prefill form 
$data = $_POST ?? [];

require_once 'dp_partials/head_nav.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>

    <!-- end nav -->
        <div class="container-fluid">
        <div class="container-fluid" >
            <div class="row">
            <div class="col-md-12">

        <section class=" py-4 ">
        <div class="container text-center">        
            <?php if(isset($user_details['name'])) { ?>

            <h3 class="">Hey, <?= $user_details['name'] ?>, It's another day to set it right! </h3>
         
            <?php } ?>

        </div>
    </section>



        <div class="col-md-12">
            <br>

            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title text-left">
                    Add Expense</h4>
                  </div>
                 
                  <div class="row">
                 <div class="mb-3">

                <div class="d-flex justify-content-end ">
                   
                <a href="budget_compare.php" class="btn btn-info text text-sm text-white" >
                   <i class="fas fa-plus-circle"></i>  Manage Your Budgets
                </a>
                 
                </div>
                </div>
              </div>


                </div>
              </div>

            <div class="card-body">
        <form id="expense-form" method="POST" 
        action="db_process/process_add_budget.php" class="form-control">


             <div>
                <label for="budget_name" class=" text-gray mb-2">Budget Title</label>
                <input class="form-control" type="text" id="budget_name" name="budget_name" placeholder="e.g., Monthly Food Spending" value="<?= htmlspecialchars('')  ?>" required>
                </div>

            <div>
                <label for="budget_type" class=" text-sm text-gray mb-2">
                    Budget Type (Income or Expense)
                </label>
                <select name="category" id="category" required
                        class=" form-select p-3 border border-gray rounded-lg bg-white shadow-sm">
                    
                    <option value="" disabled selected>Select Budget Type</option>
                    <option value="expense">Expense Budget</option>
                    <option value="income">Income Budget</option>
                </select>
            </div>

                     <!-- test category -->
                <!-- <div class="mb-3">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Select Category</option>
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                         
                    </select>            
                </div> -->

                <div class="mb-3">
                <label for="category_id" class="text-sm text-graymb-2">
                    Category
                </label>
                    <select name="category_id" id="categories" class="form-select">
                      <option value="">Select a Budget type first</option> 
                    </select>
                </div>
                    
                 
                  <!-- end test cateory -->
            <div>
                <label for="amount_limit" class=" text-sm text-gray mb-2">
                    Amount Limit (₦)
                </label>
                <input type="number" id="amount_limit" name="amount_limit" step="0.01" min="0.01" required
                       placeholder="e.g., 500.00"
                       class="p-3 border border-gray rounded-lg shadow-sm">
            </div>
     
                <div>
                <label for="start_date" class="text-sm text-gray mb-2">
                        Start Date:
                    </label>
                    <input type="date" id="start_date" name="start_date" required class="p-3 border border-gray rounded-lg shadow-sm">
                </div>
                <div>
                <label for="end_date" class="text-sm text-gray mb-2">
                    End Date:  </label>
                    <input type="date" id="end_date" name="end_date" required class="p-2 border border-gray rounded-lg shadow-sm">
                </div>

                <div>
                <label for="period_type" class=" text-gray mb-2">Recurring Period</label>
                        <select name="period_type" id="period_type" class="form-control" required>
                            <option value="monthly"> Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                </div>


                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-success" name="budgetbtn">
                    <i class="fas fa-plus-circle mr-2"></i> Set Budget
                    </button>
                </div>                 
                
                </form>

              </div>
            </div>
        </div>
</div>
</div>
</div>
</div>



    <script src="../assets//bootstrap/js/bootstrap.bundle.js"> </script>
    <script src="../assets/jquery/jquery.min.js"></script>

    <script>

        $(document).ready(function(){

       $("#category").change(function(){
        event.preventDefault();

        let category = $('#category').val();
      
        if (category == "") {
            alert('Please choose a category')
        }
         var user_id = {
            category : category,
            btn : true
            };
            
        //ajax
        $.ajax({
            url : "db_process/fetch_categories.php",
            type : "post",
            data : user_id,
            dataType : "text",
            success : function(data){
                console.log(data);
                let categories = $('#categories').html(data);
                console.log(data);
            },
            error : function(error) {
                console.log(error);
             },
         
        });

    });


        })

    </script>

</body>
</html>