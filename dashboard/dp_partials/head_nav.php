<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Expensify :Manage Your expenses at ease</title>

   <!-- Bootstrap CSS -->
    <!-- Style CSS -->
    <link href="../assets/css/style.css" rel="stylesheet" />
      <link href="../assets/animate/animate.min.css" rel="stylesheet" /> 
      <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
      <link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" />

      <style>
       
        body { font-family: "Inter", helvetica, sans-serif !important;; background-color: #f4f7f6; margin: 0;}
        .welcome { font-size: 1.5em; }
        .content-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
    </style>


</head>
<body>

    <!-- Header -->
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success"  style="background-color: #1B3530 !important;">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php">Expensify</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="add_expense.php">Add Expense</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="add_budget.php">Add Budget</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="budget_compare.php">Manage Budgets</a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="transaction.php">Transactions</a>
                        </li>
                         
                        
                    </ul>
                    <div class="d-flex">

                        <?php 

                        if (isset($user_details['name'])) {
                        ?>

                        <a href="profile.php" class="btn btn-light text-success me-2 mx-2"><i class="fas fa-user"></i> <?php echo $user_details['name'] ?> </a>

                        <?php } ?>

                        <?php 
                        if (!isset($_SESSION['is_logged_in'])) {
                         ?>
                    
                        <a href="register.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> Register</a>
                        <a href="login.php" class="btn btn-light text-success me-2"><i class="fas fa-user"></i> Login</a>

                        <?php } else{ ?>

                        <!-- loguout form -->
                        <form action="db_process/logout_db.php" method="post">
                            <button type="submit" class="btn btn-danger" name="logout_btn"><i class="fas fa-user"></i> Logout </button>
                        </form>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </nav>
    </header>