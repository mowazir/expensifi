<?php
  session_start();
require_once 'admin_guard.php';

require_once 'classes/Admin.php';
require_once 'classes/Category.php';

$adminId = $_SESSION['admin_online'];

$ad = new Admin;
$admin = $ad->get_admin_details($adminId);

 $c = new Category;
$accounts = $c->fetchAccounts();

$categories =  $c->getCategories();

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
                    <h4 class="card-title text-right">Add a Categogy</h4>
                  </div>
                 
                  <div class="row">
                 <div class="mb-3">

                <div class="d-flex justify-content-end ">
                    <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    New Category
                </button>
                 
                </div>
                </div>
              </div>


                </div>
              </div>

            <div class="card-body">
           
              
            <!-- Source Account Dropdown (Always visible) -->
            <div class="mb-6 border border-2 shadow-sm p-3 " id="source-account-group">
                <ul class="">
                  <li class="text text-muted "> Available Accounts: </li>
                  <?php foreach ($accounts as $account): ?>
                    
                  <li> <?= ucfirst($account['account_name'] )?> </li>
                  
                  <?php endforeach; ?>
                </ul>
               
            </div>


                     <!-- test category -->
                 <div class="row g-4 pb-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle g-3">
                                        <thead class="table-light">
                                            <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Category Type</th>
                                            <th>Date Added</th>
                                            <th class="text-center">Actions</th>
                                            </tr>
                                        </thead> <hr>
                                        <tbody class="">
                                            <!-- category Row 1 -->
                                      
                    <?php 
                        if (count($categories) > 0) {
                            $serial = 1;
                            foreach($categories as $category) { ?>
                                <tr>
                                    <td> <?=$serial ?> </td>
                                    <td><?= ucwords($category['category_name'] ) ?></td>
                
                                <td>

                              <?php if($category['category_type'] == 'income') { ?>

                                <span class="badge bg-success">
                                    <?=$category['category_type'] ?>  
                                  </span>
      
                             <?php } else{ ?>
                                    <span class="badge bg-danger">
                                    <?=$category['category_type'] ?>  
                                  </span>
                            <?php } ?>
                        
                                  </td>
                                <td>
                                    <span class="badge bg-dark"><?=$category['created_at'] ?></span>
                                </td>

                                  <td class="text-center d-flex">
                                        
                                 <form action="update_category.php" method="get">
                                    <button class="btn btn-warning me-1" type="submit" name="editcat">
                                    <i class="fas fa-eye"></i> 
                                    
                                    <a href="update_category.php?catid=<?=$category['category_id'] ?>">Edit Category</a>

                                  </button>
                                 </form>
                                      
                                    </td>
                                </tr>

                       <?php 
                       $serial++;
                        } ?> 
                    <?php } else {
                            echo "<tr><td colspan = '4'> nothing yet </td></tr>";
                       } ?>
                                            
                            <!-- Add more categorys as needed -->
                                </tbody>
                                    </table>
                                </div>
                                 
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



<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="categoryModalLabel">Add Categories</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <p>Let's add a category!</p> <br>
        
        <form action="process/process_add_category.php" class="form-control" method="post">
            <select name="category" id="category" class="form-select">

            <option value="">Category type</option>
               <option value="expense">Expense</option>
                <option value="income">Income</option>

                </select>  
                <br>
            <label for="modal-category" class="form-label">Category Name</label> <br>
            <input type="text" name="category_name" id="modal-category category" class="form-control"> <br>

            <div class="col-md-6">
              <button class="btn btn-md btn-success" name="category_btn">Add</button>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>





    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>