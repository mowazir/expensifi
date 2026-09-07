<?php
 session_start();
 require 'classes/User.php';

 

include "partials/header.php" ; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Monitoring Tool</title>
    
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

    <!-- Style CSS -->
      <link href= "assets/css/style.css" rel="stylesheet" />
      <link href= "assets/animate/animate.min.css" rel="stylesheet" /> 
      <link rel= "assets/stylesheet" href="fontawesome/css/all.min.css">
      <link href= "assets/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    

</head>
<body>

    <div class="main">
        <div class="container bg-light rounded-4 p-4">
             <div class="row justify-content-center align-items-center">

                <div class="col-md-6 ">
                    <img src="assets/img/login.png" alt="man walking to door" class="img-fluid">
                </div>

                <div class="col-md-6">

                    <form action="login.php" method="post">

                        <h3>Oops! Forget Your password?</h3>
                        <p><small class=" text-muted lh-base"> Don't fret! It's being <span class="banner rounded" style="padding: 8px;" > Human </span> </small></p>

                    <div class="mb-3">
                        <label for="email">email</label> <br>
                        <input type="email" name="email" id="email" placeholder="email" class="form-control sShadow-none rounded" autofocus="true"> <br>
                        <button type="submit" class="btn btn-primary shadow-none rounded w-100">Reset Password</button>
                    </div>


                    <div class="mb-3">
                        <p class="my-2 text-muted "> <small class=""> Go back to the login page ?</small> </p>
                       <button type="submit" class="btn btn-primary shadow-none rounded w-80 btn">Login Page</button>

                    </div>

                    </form>

                </div>

             </div>

        </div>
         <section class=" py-5 ">
        <div class="container text-center">        

        </div>
        </section>

    </div>
    
    
     <!-- footer -->

    
         <!-- footer end -->


        <script src="assets/bootstrap/js/bootstrap.bundle.js"> </script>
    
<?php include "partials/footer.php" ?>

       