<?php
  session_start();
require_once 'admin_guard.php';

require_once 'classes/Admin.php';
require_once 'classes/Category.php';

$adminId = $_SESSION['admin_online'];

$ad = new Admin;
$admin = $ad->get_admin_details($adminId);


$catid = $_GET['catid'];
echo $catid;


$c = new Category;
$accounts = $c->fetchAccounts();

$categories =  $c->getCategoryById($catid);

?>

 <?php require_once 'partials/heading.php';  ?>

      <!-- ========== table components start ========== -->
      <section class="table-components">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Admin </h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Update category</a>
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

            <div class="col-sm-4 col-lg-4">
              <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <div class="me-3 bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                    <i class="fas fa-pen"></i>
                  </div>
                  <div>
                    <p class="mb-0 text-muted">Update Category </p>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-12">
            <br>

            <div class="card">


                <!-- Source Account Dropdown (Always visible) -->
            <div class="mb-6 border border-2 shadow-sm p-3 " id="source-account-group">
                <ul class="">
                  <li class="text text-muted "> Available Accounts: </li>
                  <?php foreach ($accounts as $account): ?>
                    
                  <li> <?= ucfirst($account['account_name'] )?> </li>
                  
                  <?php endforeach; ?>
                </ul>
               
            </div>
                              
              </div>

            <div class="card-body">
    
            <div class="card-body">
            <form id="expense-form" method="POST" 
            action="process/pro_update_category.php" class="form-control">
           
                     <!-- test category -->
                <div class="mb-3 col-md-4 ">
                    <label for="">Default Category Type</label>
                    <input class="form-control bg-warning" type="text" value="<?= $categories['category_type']  ?>" readonly>
                  </div>

                <div class="mb-3">
                    <label for="category">Category</label>
                     <select name="category" id="category" class="form-select">
                        
                        <option value="<?= $categories['category_type']  ?>">Expense</option>
                        <option value="income">Income</option>
                                                 
                    </select>           
                </div>

                <input type="hidden" name="catid" value="<?= $catid ?>">
   
                  <!-- end test cateory -->
                  <div class="mb-3">
                    <label for="">Category Description</label>
                    <input class="form-control" type="text" value="<?= $categories['category_name']  ?>" name='category_name' >
                  </div>



                    <div class="mb-3 mt-4">
                        <button type="submit" class="btn btn-success" name="editcat">
                        <i class="fas fa-plus-circle"></i> Edit
                        </button>
                    </div>                 
                
                </form>

              </div>
                 
                  <!-- end test cateory -->
              
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