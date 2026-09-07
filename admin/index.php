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
                  <h2>Admin</h2>
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
<!-- 
          <div class="row mb-20">
            <div class="col-sm-6 col-lg-4">
              <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <div class="me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-utensils"></i>
                  </div>
                  <div>
                    <h4 class="mb-0">1,254</h4>
                    <p class="mb-0 text-muted">Total Recipes</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-4">
              <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <div class="me-3 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-users"></i>
                  </div>
                  <div>
                    <h4 class="mb-0">3,402</h4>
                    <p class="mb-0 text-muted">Active Users</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-4">
              <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                  <div class="me-3 bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                  <div>
                    <h4 class="mb-0">128</h4>
                    <p class="mb-0 text-muted">Total Orders</p>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

        
    
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
