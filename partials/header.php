<?php  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Expensify :Easy management software</title>

   
    <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
    <link href="animate/animate.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
 
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="stylesheet" type="text/css" href="assets/style2.css">


</head>
<body>
    <!-- Header -->
    <header class="sticky-top">

        <nav class="navbar navbar-expand-lg navbar-dark bg-info" 
        style="background-color: #1B3530 !important;">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php">Expensify</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="recipes.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex">

                        <?php 

                        if (isset($user_details['name'])) {
                        ?>

                        <a href="profile.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> <?php echo $user_details['name'] ?> </a>

                        <?php } ?>

                        <?php 
                        if (!isset($_SESSION['is_logged_in'])) {
                         ?>
                    
                        <a href="register.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> Register</a>
                        <a href="login.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> Login</a>

                        <?php } else{ ?>

                        <!-- loguout form -->
                        <form action="process/process_logout.php" method="post">
                            <button type="submit" class="btn btn-danger" name="logout_btn">Logout</a>
                        </form>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </nav>
    </header>