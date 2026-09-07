<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<title>Admin Login</title>
</head>
<body>

	<div class="container bg bg-success text-white">
		
		<div class="row">
			<div class="text-center">
			<h1>Admins Login Here</h1>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-md-6">
				<form action="process/process_login.php" method="post">
					<?php require 'partials/alert.php'; ?>

					<input type="text" name="username" id="username" placeholder="username" class="form-control mb-2"> <br>
					<input type="password" name="password" class="form-control mb-2"> <br>
					<button name="adminlog" type="submit" class="btn btn-info">Login</button>
				</form>
			</div>
		</div>


	</div>

</body>
</html>

