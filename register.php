<?php
 session_start(); //start again

//include 'classes/User.php';
include "partials/header.php";


?>


<body>

    <div class="main">
        <div class="container bg-light rounded-4 p-5">
             <div class="row justify-content-center align-items-center">

                <div class="col-lg-6 ">
                     <h2>Go back <a class=" btn rounded-3 " href="index.php">Home</a> </h2>
                    <img src="assets/img/login.png" alt="man walking to door" class="img-fluid">
                </div>

                <div class="col-lg-6">

                    <form action="process/process_reg.php" method="post">

                        <h3>Welcome!</h3>
                       <p> <small class=" text-muted"> Let's get you started</small></p>

                       <!-- <div>
                        <ul>
                          <li> <?php# if(isset($error)) {
                            # echo "$error";
                         # } ?> </li>
                        </ul>
                    </div> -->


                    <?php
    if (isset($_SESSION['error_msg']) ) {
        echo "<p> ". $_SESSION['error_msg'] ." </p>";
         unset($_SESSION['error_msg']);
     }
  ?>

  <?php
    if (isset($_SESSION['msg']) ) {
        echo "<p> ". $_SESSION['msg'] ." </p>";
         unset($_SESSION['msg']);
     }
  ?>


                    <div class="mb-3">
                        <label for="us">Username</label> <br>
                        <input type="text" name="username" id="username" placeholder="username" class="form-control shadow-none rounded" autofocus="true">
                    </div>

                    <div class="mb-3">
                        <label for="us">Email</label> <br>
                        <input type="email" name="email" id="email" placeholder="email" class="form-control shadow-none rounded" autofocus="true">
                    </div>

                    <div class="mb-3">
                        <label for="us">Password</label> <br>
                        <input type="password" name="password" id="password" placeholder="password" class="form-control shadow-none rounded">
                    </div>

                    <div class="mb-3">
                        <label for="us">Confirm Password</label> <br>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="confirm_password" class="form-control shadow-none rounded">
                    </div>

                    <div class="mb-3">
                       <button type="submit" name="btn_reg" class="btn btn-primary shadow-none rounded w-50">Register</button>
                    </div>

                    <div class="mb-3">
                        <p class="my-2 text-muted "> <small class=""> Already Have an  Account ?</small> </p>
                       <a href ='login.php' type="submit" class="btn btn-primary shadow-none rounded w-50">Login</a>
                    </div>

                    </form>

                </div>

             </div>

        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.js"> </script>
    
<?php include "partials/footer.php" ?>
