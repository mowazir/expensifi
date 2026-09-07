<?php 
session_start();

require '../guard.php';
require '../classes/User.php';

$user_online = $_SESSION['is_logged_in'];

$user = new User;
$user_details = $user->get_user_details($user_online);

require 'dp_partials/head_nav.php';

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    
    <!-- Bootstrap CSS -->


    <!-- end nav -->
             

        <div class="container-fluid ">
            <div class="row">          
                <div class="col-md-12">

                 <section class=" py-5">
        <div class="container text-center">        
            <?php if(isset($user_details['name'])) { ?>

            <h3 class="">Welcome back, <?= $user_details['name'] ?> </h3>
            <h5>Your Fave tagline <span class="text text-white bg-success px-2"><?= $user_details['bio'] ?> </span> </h5>
         
            <?php } ?>

        </div>
    </section>
            
            <form action="db_process/process_update_profile.php" class="form-control" method="post">

            <label for="name" class="form-label">Name:</label><br>
            <input type="text" name="name" id="username"  class="form-control" value="<?= $user_details['name'] ?>"> <br>

            <label for="email" class="form-label">Bio:</label><br>
            <textarea placeholder="something about yourself..." name='bio'><?= $user_details['bio'] ?></textarea> <br>

            <label for="email" class="form-label">Email:</label><br>
            <input type="email" name="profile" id="profile" class="form-control" value="<?= $user_details['email'] ?>" readonly > 
            <br> 

             <button type="submit" class="btn btn-primary w-100" name="profileupdate">Update Profile</button> 

        </form>
                  
            </div>
        </div>
    </div>

        </div>
    </div>


       <script src="../assets/bootstrap/js/bootstrap.bundle.js"> </script>
    <!-- Script JS -->
    <script src="./script.js"></script>
</body>
</html>

