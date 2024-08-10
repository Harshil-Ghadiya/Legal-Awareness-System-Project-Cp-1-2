<?php
	session_start();
	include("db_con/dbCon.php");
?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Font Awesome CSS -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/media.css">
		<title>Lawyer Management System</title>
		<style>
			.customnav .navbar-nav {
				flex: 1;
				justify-content: space-between;
				align-items: center;
			}
			.customnav .navbar-brand {
				flex: 0 1 auto;
			}
			.customnav .form-inline {
				flex: 1;
				display: flex;
				justify-content: center;
			}
			.customnav .form-inline .form-control {
				border-radius: 20px;
				background-color: rgba(255, 255, 255, 0.5); /* White with 50% transparency */
				color: #fff;
				border: 1px solid rgba(255, 255, 255, 0.5);
			}
			.customnav .form-inline .form-control::placeholder {
				color: rgba(255, 255, 255, 0.7); /* Placeholder text with 70% transparency */
			}
			.customnav .form-inline .btn {
				border-radius: 20px;
				margin-left: 10px;
				background-color: rgba(255, 255, 255, 0.5); /* White with 50% transparency */
				color: #fff;
				border: 1px solid rgba(255, 255, 255, 0.5);
			}
			.customnav .navbar-nav .nav-item {
				flex: 0 1 auto;
			}

			footer {
				background-color: rgba(255, 255, 255, 0.5); /* White with 50% transparency */
				color: #fff;
				padding: 20px 0;
			}

			footer h5 {
				margin: 0;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<header class="customnav bg-success">
			<div class="container">
				<nav class="navbar navbar-expand-lg">
					<a class="navbar-brand cus-a" href="index.php">Legal Awareness System</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<form class="form-inline my-2 my-lg-0" action="search_law.php" method="GET">
								<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
								<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
							</form>
							<li class="nav-item">
								<a class="nav-link cus-a" href="lawyers.php">Lawyers</a>
							</li>
							
							<?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE) { ?>
								<li class="nav-item">
									<a class="nav-link cus-a" href="user_dashboard.php">Dashboard</a>
								</li>
								<li class="nav-item">
									<a class="nav-link cus-a" href="logout.php">Logout</a>
								</li>
							<?php } else { ?>
								<li class="nav-item">
									<a class="nav-link cus-a" href="login.php">Login</a>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle cus-a" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Register
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="lawyer_register.php">Register as a Lawyer</a>
										<a class="dropdown-item" href="user_register.php">Register as a User</a>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</nav>
			</div>
		</header>

		<section class="banner">
			<div class="container">
				<div class="row">
					<div class="col-md">
						<div class="banner_content">
							<h1>Discover Your Ideal Lawyer Here!</h1>
							<p>Your Legal Journey Starts Now</p>
							<br>
							<a href="lawyers.php" class="btn-lg cusbutton">Find Lawyers</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="aboutus">
			<div class="container">
				<div class="row">
					<div class="col-md-6 ml-auto">
						<h1>About Us</h1>
						<p>Welcome to our Lawyer Management System, where we put you in control. Our platform is all about making the legal process as effortless as possible. We've created a space where you, the user, can browse, choose, and book appointments with lawyers who best suit your unique needs. It's your legal journey, your way, and we're here to make it seamless. Trust us to connect you with the right legal expertise when you need it most.</p>
					</div>
					<div class="col-md-6">
						<div class="contact-us-bar">
							<h1 class="contact-header">Get in Touch</h1>
							<div class="contact-details">
								<p><i class="fas fa-map-marker-alt"></i> Address: D-18, Block-4</p>
								<p><i class="fas fa-phone"></i> Phone: +9234-332-08987</p>
								<p><i class="fas fa-envelope"></i> Email: lawyers@contact.com</p>
								<p><i class="fas fa-headset"></i> Customer Support: 021-58585-3</p>
								<p><i class="far fa-clock"></i> Office Hours: 9am-4pm</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<footer class="bg-success">
			<div class="container">
				<div class="row">
					<div class="col">
						<h5>All rights reserved. 2023</h5>
					</div>
				</div>
			</div>
		</footer>

		<!-- Optional JavaScript -->
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>
</html>
