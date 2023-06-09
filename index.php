<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="icon" href="assets/images/caduceus-symbol.png" type="image/x-icon">
  <style>
        body {
			background-image: url('assets/images/bg-01.jpg');
			background-size: cover;
			background-position: center;
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		button:focus,
		button:active {
		outline: none;
		box-shadow: none;
		}
		
		.custom-container {
			width: 100%;
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
		}

    </style>
  
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="css/styles.css" rel="stylesheet" />
  <script src="js/slim.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container custom-container">
		<div class="row justify-content-center mt-5">
			<div class="col-md-4">
			<div class="card">
				<div class="card-header text-center fs-2 fw-bold">
				Laparoscopic Trainer Login
				</div>
				<div class="card-body">
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="form-group">
					<input type="text" class="form-control" id="username" name="user" placeholder="Username" value="" required>
					</div>
					<div class="form-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" required>
					</div>
					<div class="d-flex justify-content-center">
					<button type="submit" class="btn btn-primary bg-black">Sign In</button>
					</div>
				</form>
				</div>
			</div>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="loginErrorModalLabel">Incorrect Username or Password</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<p>Please check your username and password and try again.</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
		</div>
		</div>
	</div>
	</div>


  <?php
    // PHP code for validating the login credentials and displaying the modal if necessary
    include "includes/config.php";
    include "includes/funciones.php";

    session_start();

    if ($_POST) {
      $user = $_POST['user'];
      $password = $_POST['password'];
      $pass_c = sha1($password);

      $mysqli = conectar();

      $sql = "SELECT idUser, password, fullName, type FROM users WHERE user='$user'";
      $res = $mysqli->query($sql);
      $num = $res->num_rows;

      if ($num > 0) {
        $row = $res->fetch_assoc();
        $pass_bd = $row['password'];
        if ($pass_bd == $pass_c) {
          $_SESSION['idUser'] = $row['idUser'];
          $_SESSION['userName'] = $user;
          $_SESSION['fullName'] = $row['fullName'];
          $_SESSION['type'] = $row['type'];
          redir("/EndoTrainer/main.php");
        } else {
          echo "<script>
                  $(document).ready(function() {
                    $('#loginErrorModal').modal('show');
                  });
                </script>";
        }
      } else {
        echo "<script>
                $(document).ready(function() {
                  $('#loginErrorModal').modal('show');
                });
              </script>";
      }
    }
  ?>

</body>
</html>

