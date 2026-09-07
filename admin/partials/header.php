<?php  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Expensify :Recipe Sharing App</title>

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
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
                            <a class="nav-link" href="manage_category.php">Manage Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create_category.php">Create Category</a>
                        </li>
                    </ul>
                    <div class="d-flex">

                        <?php 

                        if (isset($user_details['fullname'])) {
                        ?>

                        <a href="profile.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> <?php echo $user_details['fullname'] ?> </a>

                        <?php } ?>

                        <?php 
                        if (!isset($_SESSION['user_online'])) {
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