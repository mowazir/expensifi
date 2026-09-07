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

        <section class=" py-5 ">
        <div class="container text-center">        
            <?php if(isset($user_details['name'])) { ?>

            <h3 class="">Welcome back, <?= $user_details['name'] ?> </h3>
         
            <?php } ?>

        </div>
    </section>



        <div class="col-md-12">
            <br>

            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title text-center">Add Expense</h4>
                  </div>
                 
                  <div class="row">
                 <div class="mb-3">

                <div class="d-flex justify-content-end ">
                    <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    New Category
                </button>
                 
                </div>
                </div>
              </div>


                </div>
              </div>

            <div class="card-body">
            <form id="expense-form" method="POST" 
            action="db_process/process_add_expense.php" class="form-control">
                  <div class="">
                    <label for="dateexpense">Date of Expense</label>
                    <input class="form-control" type="date" id="dateexpense" name="date_incurred" value="<?php  echo date('Y-m-d'); ?>" >
                  </div> 


                   <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Transaction Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="transaction_type" value="expense" id="type-expense" class="form-radio h-4 w-4 text-red-600" checked>

                        <span class="ml-2 text-gray-700 font-medium">Expense</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="transaction_type" value="income" id="type-income" class="form-radio h-4 w-4 text-green-600" >
                        <span class="ml-2 text-gray-700 font-medium">Income</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="transaction_type" value="transfer" id="type-transfer" class="form-radio h-4 w-4 text-blue-600" >
                        <span class="ml-2 text-gray-700 font-medium">Transfer</span>
                    </label>
                </div>
            </div>

                       <!-- Source Account Dropdown (Always visible) -->
            <div class="mb-6" id="source-account-group">
                <label for="account_id" class=" mb-2">Account</label>
                <select name="account_id" id="account_id" class="form-select" required>
                    <option value="">Select Account </option>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?= htmlspecialchars($account['account_id']) ?>"

                            <?= (isset($data['account_id'])
                         && $data['account_id'] == $account['account_id']) ? 
                            'selected' : '' ?>>

                            <?= htmlspecialchars($account['account_name']) ?>

                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($accounts)): ?>
                    <p class="error-message">You have no accounts! Please add one first.</p>
                <?php endif; ?>
            </div>

            <!-- Destination Account Dropdown (Hidden for Transfers) -->
            <div class="mb-6 hidden" id="destination-account-group">
                <label for="destination_account_id" class=" mb-2">Destination Account</label>
                <select name="destination_account_id" id="destination_account_id" class="form-select">
                    <option value="">-- Select a Destination Account --</option>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?= htmlspecialchars($account['account_id']) ?>"
                            <?= (isset($data['destination_account_id']) && $data['destination_account_id'] == $account['account_id']) ? 'selected' : '' ?> >
                            <?= htmlspecialchars($account['account_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

                     <!-- test category -->
                <div class="mb-3">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Choose a Category</option>
                        <option value="expense">Expense</option>
                        <option value="income">Income</option>
                         
                    </select>            
                </div>

                <div class="mb-2">
                    <select name="categories" id="categories" class="form-select">
                      <option value="">Choose a Category</option> 
                    </select>
                </div>
                    
                 
                  <!-- end test cateory -->
                  <div class="">
                    <label for="costitem">Cost of Item</label>
                    <input class="form-control" type="number" id="costitem" name="amount" required>
                  </div>

                  <div class="">
                    <label for="category-description">Short Memo</label>
                    <textarea class="form-control" id="category-description" name="memo" required></textarea>
                  </div>


                    <div class="mb-3 mt-4">
                        <button type="submit" class="btn btn-success" name="expensebtn">
                        <i class="fas fa-plus-circle"></i> Add new Expense
                        </button>
                    </div>                 
                
                </form>

                <div id="success-message" class="alert alert-success" style="display:none;">
                  Expense added successfully.
                </div>
              </div>
            </div>

</div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="categoryModalLabel">Add Categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <form action="db_process/process_add_category.php" class="form-control" method="post">
            <select name="category" id="category" class="form-select">

            <option value="">Category type</option>
               <option value="expense">Expense</option>
                <option value="income">Income</option>

                </select>  
                <br>
            <label for="modal-category" class="form-label">Category Name</label> <br>
            <input type="text" name="category_name" id="modal-category category" class="form-control"> <br>

            <button class="btn btn-success" name="category_btn">Add</button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
            // beforeSend : function() {
            //  //show a spinner, loda
            // var loader = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>'
            // $('#categories').hide(),
            // $('#loda').empty(),
            // $('#loda').append(loader)
            // },
            // complete : function(){
            //     //hide the spinner, stop loda
            //     $('#loda').empty(),
            //      $('#categories').show()
                
            // } 
        });

    });


        })

    </script>

</body>
</html>

