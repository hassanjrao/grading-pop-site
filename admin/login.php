<?php
ob_start();
include('includes/db.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include_once("includes/head.php"); ?>

	<title>Login</title>

</head>

<body class="page-body login-page login-form-fall">



	<div class="login-container">

		<div class="login-header login-caret">

			<div class="login-content">

				<a href="index.html" class="logo">
					<img src="../images/logo.png" width="320" alt="" />
				</a>

				<p class="description">Dear user, log in to access the admin area!</p>


			</div>

		</div>


		<div class="login-form">

			<div class="login-content">

				<?php

				if (isset($_POST['submit_login'])) {


					
					$username = $_POST['username'];
					$pass = $_POST['pass'];



					$query_user = $conn->prepare("SELECT * FROM admin WHERE username = '$username' AND password = '$pass'");
					$query_user->execute();
					$result11 = $query_user->fetch(PDO::FETCH_ASSOC);

					if ($result11) {
				?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<strong>Congrats!</strong>Login Successful.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<?php
						if (isset($_POST["remember_me"])) {
							setcookie("remember_me", $result11['id'], time() + (86400 * 30), "/"); // 86400 = 1 day
							$_SESSION['admin_id'] = $result11['id'];
							
						} else {
							$_SESSION['admin_id'] = $result11['id'];
						
						}
						header("location:index.php");
					} else {
						?>

					

						<div class="alert alert-dismissible alert-danger" role="alert">
							<strong>Oops!</strong> Invalid username or Password.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

				<?php
					}
				}
				?>

				<form method="post">

					<div class="form-group">

						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-user"></i>
							</div>

							<input required="" type="username" class="form-control" name="username" id="username" placeholder="username" autocomplete="off" />
						</div>

					</div>

					<div class="form-group">

						<div class="input-group">
							<div class="input-group-addon">
								<i class="entypo-key"></i>
							</div>

							<input required="" type="password" class="form-control" name="pass" id="password" placeholder="Password" autocomplete="off" />
						</div>

					</div>

					<div class="form-group">
						<button type="submit" name="submit_login" class="btn btn-primary btn-block btn-login">
							<i class="entypo-login"></i>
							Login In
						</button>
					</div>


				</form>

				

			</div>

		</div>

	</div>


	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>

</body>

</html>