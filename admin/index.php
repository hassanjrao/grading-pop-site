<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

	if (empty($_SESSION['admin_id'])) {

		header('location:login.php');
	}
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include_once("includes/head.php"); ?>

	<title>Dashboard</title>

</head>

<body class="page-body  page-fade" data-url="http://neon.dev">

	<div class="page-container">
		<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

		<!-- leftbar starts -->

		<?php include_once("includes/left-bar.php"); ?>

		<!-- leftbar ends -->

		<div class="main-content">

			<div class="row">

				<!-- header starts-->
				<?php include_once("includes/header.php"); ?>
				<!-- header ends -->


			</div>

			<hr />

			<?php

			$query = $conn->prepare("SELECT id from cards");
			$query->execute();
			$total_cards=$query->rowCount();


			// $query = $conn->prepare("SELECT id from listings");
	



			
			?>





			<div class="row">
				<div class="col-sm-3 col-xs-6">

					<div class="tile-stats tile-red">
						<div class="icon"><i class="entypo-cards"></i></div>
						<div class="num" data-start="0" data-end="<?php echo $total_cards ?>" data-postfix="" data-duration="1500" data-delay="0">0</div>

						<h3>Total Cards</h3>
						
					</div>

				</div>


				<div class="clear visible-xs"></div>

				

				
			</div>



			<br />






			<!-- Footer starts -->
			<?php include_once("includes/footer.php"); ?>
			<!-- Footer end -->
		</div>



	</div>





	<!-- scripts starts -->

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/TweenMax.min.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>
	<script src="assets/js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>
	<!-- scripts ends -->

</body>

</html>