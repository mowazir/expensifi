<?php
  session_start();
require_once 'admin_guard.php';

require 'classes/Admin.php';

$adminId = $_SESSION['admin_online'];

$ad = new Admin;
$admin = $ad->get_admin_details($adminId);

?>

 <?php require 'partials/heading.php';  ?>

      <!-- ========== table components start ========== -->
      <section class="table-components">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Admin Dashboard</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Admin Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Expensify
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== Page Content start ========== -->

          <div class="col-md-12">
            <br>

            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title text-center">Add Categogy</h4>
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
             <!--  -->
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
                        <i class="fas fa-plus-circle"></i> Add new Category
                        </button>
                    </div>                 
                
                </form>

                <div id="success-message" class="alert alert-success" style="display:none;">
                  Expense added successfully.
                </div>
              </div>
            </div>

</div>

        
    
          <!-- ========== Page Content end ========== -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== table components end ========== -->

      <!-- ========== footer start =========== -->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
            
              </div>
            </div>
            <!-- end col-->
            <div class="col-md-6">
              <div class="terms d-flex justify-content-center justify-content-md-end">
                <a href="#" class="text-sm">Term & Conditions</a>
                <a href="#" class="text-sm ml-15">Privacy & Policy</a>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </footer>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
