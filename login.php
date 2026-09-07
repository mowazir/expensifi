<?php
 session_start();
 require 'classes/User.php';

 

include "partials/header.php" ; 
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

                    <form action="process/process_login.php" method="post">


                        <h3>Welcome back!</h3>
                        <p><small class=" text-muted"> Let's quickly log you in </small></p>

                        <?php if (! empty($error)) : ?>
                            <p class="alert alert-warning"><?= $error ?></p>
                        <?php endif; ?>

                        <?php include 'partials/msg.php' ?>

                    <div class="mb-3">
                        <label for="us">Email</label> <br>
                        <input type="email" name="email" id="email" placeholder="enter your email" class="form-control shadow-none rounded" autofocus="true">
                    </div>

                    <div class="mb-3">
                        <label for="us">Password</label> <br>
                        <input type="password" name="password" id="password" placeholder="enter password" class="form-control shadow-none rounded" autofocus="true">
                    </div>

                    <div class="mb-3">
                       <button type="submit" class="btn btn-primary shadow-none rounded w-100" name="login">Login</button>
                    </div>

                    <div class="mb-3">
                        <p class="my-2 text-muted text-center"> <small class=""> Forgot your password ?</small> </p>
                       <a href="forget_password.php" class="btn btn-primary shadow-none rounded w-100">Forget Password</a>
                    </div>

                     <div class="mb-3">
                        <p class="my-2 text-muted "> <small class=""> Not an existing User ?</small> </p>
                       <a href="register.php" class="btn btn-primary shadow-none rounded w-50">Sign Up</a>
                    </div>

                     </form>

                </div>

             </div>

        </div>
    </div>

    <section class=" py-5 ">
        <div class="container text-center">        
            

        </div>
    </section>
    
   
<script src="assets/bootstrap/js/bootstrap.bundle.js"> </script>

<?php include "partials/footer.php" ?>