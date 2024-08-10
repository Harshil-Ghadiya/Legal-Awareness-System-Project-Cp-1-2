<?php
	session_start();
	if($_SESSION['login']==TRUE AND $_SESSION['status']=='Active')
	{
		
		//session_start();
		include("db_con/dbCon.php");
		if(isset($_POST['post'])) {
            // Check if date and description are not empty
            if(!empty($_POST['date']) && !empty($_POST['description'])) {
                // Process the form submission
                // Your existing code for saving the booking goes here
            } else {
                // If date or description is empty, display an error message
                echo "<script>alert('Please fill in both date and description fields.');</script>";
            }
		}
	}
	?>
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Bootstrap CSS -->
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<link rel="stylesheet" href="css/all.css">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/media.css">
		<title></title>
	</head>
	<bod>
		<header class="customnav bg-success">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<nav class="navbar navbar-expand-lg ">
							<a class="navbar-brand cus-a" href="index.php">Legal Awareness System</a>
							
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<ul class="navbar-nav ml-auto ">
									
									<li class="">
										<a class="nav-link cus-a" href="search_law.php">Laws</a><!--lawyers.html page-->
									</li>
									<li class="">
										<a class="nav-link cus-a" href="lawyers.php">Lawyers</a><!--lawyers.html page-->
									</li>
									
									<?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE){ ?>
										<li class="">
											<a class="nav-link cus-a" href="user_dashboard.php">Dashboard</a>
										</li>
										<li class="">
											<a class="nav-link cus-a" href="logout.php">Logout</a>
										</li>
									<?php }else{ ?>
										<li class="">
											<a class="nav-link cus-a" href="login.php">Login</a>
										</li>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle cus-a" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Register
											</a>
											<div class="dropdown-menu" aria-labelledby="navbarDropdown">
												<a class="dropdown-item" href="lawyer_register.php">Register as a lawyer</a><!--redirect lawyer register page-->
												<a class="dropdown-item" href="user_register.php">Register as a user</a><!--redirect user register page-->
											</div>
										</li>
									<?php }?> 
									
								</ul>
								
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>
		<body>
				<div class="d-flex" id="wrapper">
					
					<!-- Sidebar -->
					<div class="bg-light border-right" id="sidebar-wrapper">
					  <div class="sidebar-heading">My Profile</div>
						<div class="list-group list-group-flush">
							<a href="user_dashboard.php" class="list-group-item list-group-item-action bg-light">Dashboard</a><!--this page-->
							<a href="lawyerfind.php" class="list-group-item list-group-item-action bg-light">Lawyers</a><!--this page-->
							<a href="user_profile.php" class="list-group-item list-group-item-action bg-light">Edit Profile</a><!--user_profile page-->
							<a href="user_booking.php" class="list-group-item list-group-item-action bg-light">My booking requests</a><!--booking page-->
							<a href="update_password.php" class="list-group-item list-group-item-action bg-light">Update Password</a><!--booking page-->
							<!--<a href="lawyerfind.php" class="list-group-item list-group-item-action bg-light">profile</a>-->
						</div>
					</div>
			    <div class="container">
				
				<div class="row">
				<?php
						include_once 'db_con/dbCon.php';
						$conn = connect();
						
						$result = mysqli_query($conn,"SELECT * FROM user,lawyer WHERE user.u_id=lawyer.lawyer_id and user.status='Active' AND user.u_id='" . $_GET['u_id'] . "'");
						$result1=mysqli_query($conn,"SELECT client_id from client WHERE client.client_id='" . $_SESSION['client_id'] . "'");
						if($row = mysqli_fetch_array($result)) {
					?>
						<div class="col-md-3">
							<div class="sideprofile">
								<img src="images/upload/<?php echo $row["image"]; ?>" class="img-fluid profile_img" alt="profile picture">
								<h2><?php echo $row["first_Name"]; ?> <?php echo $row["last_Name"]; ?></h2>
								<h4><?php echo $row["speciality"]; ?></h4>
								<hr>
							</div>
						</div>
						<div class="col-md-9">
							<div class="mainprofile">
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="contact_number"><b>Contact number :</b></label>
									</div>
									<div class="col-md-8">
										<p id="contact_number"><?php echo $row["contact_Number"]; ?></p>
									</div>
								</div>
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="email"><b>Email :</b></label>
									</div>
									<div class="col-md-8">
										<p id="email"><?php echo $row["email"]; ?></p>
									</div>
								</div>
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="education"><b>Education :</b></label>
									</div>
									<div class="col-md-8" id="education">
										<p><?php echo $row["university_College"]; ?></p>
										<p><?php echo $row["degree"]; ?></p>
										<p><?php echo $row["passing_year"]; ?></p>
									</div>
								</div>
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="practising_location"><b>Practising location :</b></label>
									</div>
									<div class="col-md-8" id="practising_location">
										<p><?php echo $row["full_address"]; ?></p>
										<p><?php echo $row["city"]; ?></p>
										<p><?php echo $row["zip_code"]; ?></p>
									</div>
								</div>
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="practising_length"><b>Practising length :</b></label>
									</div>
									<div class="col-md-8">
										<p id="practising_length"><?php echo $row["practise_Length"]; ?></p>
									</div>
								</div>
								<div class="infogroup row">
									<div class="col-md-4">
										<label for="case_handles"><b>Type of case handles:</b></label>
									</div>
									<div class="col-md-8">
										<p id="case_handles"><?php echo $row["case_handle"]; ?></p>
									</div>
								</div>  
								
								<form action="save_booking.php" method="post">
									<div class="row">
                                    <input type="hidden" name="lawyer_id" value="<?php echo $row['lawyer_id']; ?>">
									<?php if($row = mysqli_fetch_array($result1)) { ?>
									<input type="hidden" name="client_id" value="<?php echo $row['client_id']; }?>">
										<div class="col-md-3">
											<label for="bookingDate"><b>Book for appointment:</b></label>
										</div>
										<div class="col-md-3">
											<input type="date" id="bookingDate" name="date" required>
										</div>
									</div>
								
<div class="row mt-3">
    <div class="col-md-3">
        <label for="time_slot"><b>Time Slot :</b></label>
    </div>
    <div class="col-md-3">
        <select name="time_slot" id="time_slot" required>
            <option value="">Select Time Slot</option>
            <!-- Options will be dynamically added here -->
        </select>
    </div>
    <div class="col-md-6" id="time_slot_message"></div> <!-- Placeholder for time slot message -->
</div>

<script>
    // Get today's date
    var today = new Date().toISOString().split('T')[0];
    // Set the minimum date for the booking date input field
    document.getElementById('bookingDate').min = today;

    document.getElementById('bookingDate').addEventListener('change', function() {
        var selectedDate = new Date(this.value);
        var todayDate = new Date();
        var timeSlotSelect = document.getElementById('time_slot');
        var timeSlotMessage = document.getElementById('time_slot_message');
        
        timeSlotSelect.innerHTML = '<option value="">Select Time Slot</option>'; // Reset options
        timeSlotMessage.innerHTML = ''; // Clear previous message

        // Define all available time slots
        var timeSlots = [
            "09:00-10:00",
            "10:00-11:00",
            "11:00-12:00",
            "12:00-01:00",
            "01:00-02:00",
            "02:00-03:00",
            "03:00-04:00",
            "04:00-05:00",
			"05:00-06:00",
			"06:00-07:00",
            "07:00-08:00",
			"09:00-10:00"
        ];

        // If the selected date is today, filter out past time slots
        if (selectedDate.toDateString() === todayDate.toDateString()) {
            var currentTime = todayDate.getHours() + ':' + todayDate.getMinutes();
            for (var i = 0; i < timeSlots.length; i++) {
                var slotEndTime = timeSlots[i].split('-')[1];
                if (slotEndTime > currentTime) {
                    var option = document.createElement('option');
                    option.value = timeSlots[i];
                    option.textContent = timeSlots[i].replace('-', ' - ');
                    timeSlotSelect.appendChild(option);
                }
            }
            // Display message for past time slots
            timeSlotMessage.innerHTML = 'No available time slot';
        } else {
            // If the selected date is in the future, display all time slots
            for (var j = 0; j < timeSlots.length; j++) {
                var option = document.createElement('option');
                option.value = timeSlots[j];
                option.textContent = timeSlots[j].replace('-', ' - ');
                timeSlotSelect.appendChild(option);
            }
        }
    });
</script>

									<div class="row mt-3">
										<div class="col-md-6">
											<textarea name="description" id="description" class="form-control" rows="4" placeholder="Write description if any"></textarea>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-3 offset-md-9">
											<?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE){ ?>
												<input name="post" type="submit" class="btn btn-block btn-info" value="Request booking" />
											<?php }else{ ?>
												<h6><a href="login.php">To request for lawyer booking, please login or register first</a></h6>
											<?php }?> 
										</div>
									</div>
								</form>
								
							</div>
						</div>
					<?php
						}
					?>
					
				</div>
			</div>
	
		</div>
		</body>
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
	
	
		...
<script>
    // Get today's date and time
    var today = new Date();
    var todayDate = today.toISOString().split('T')[0];
    var currentTime = today.getHours() + ':' + today.getMinutes();

    // Set the minimum date for the booking date input field
    document.getElementById('bookingDate').min = todayDate;

    document.getElementById('bookingDate').addEventListener('change', function() {
        var selectedDate = new Date(this.value);
        var timeSlotSelect = document.getElementById('time_slot');
        var timeSlotMessage = document.getElementById('time_slot_message');
        
        timeSlotSelect.innerHTML = '<option value="">Select Time Slot</option>'; // Reset options
        timeSlotMessage.innerHTML = ''; // Clear previous message

        // Define all available time slots
        var timeSlots = [
            "09:00-10:00",
            "10:00-11:00",
            "11:00-12:00",
            "12:00-01:00",
            "01:00-02:00",
            "02:00-03:00",
            "03:00-04:00",
            "04:00-05:00"
        ];

        // If the selected date is today, filter out past time slots
        if (selectedDate.toDateString() === today.toDateString()) {
            for (var i = 0; i < timeSlots.length; i++) {
                var slotEndTime = timeSlots[i].split('-')[1];
                if (slotEndTime > currentTime) {
                    var option = document.createElement('option');
                    option.value = timeSlots[i];
                    option.textContent = timeSlots[i].replace('-', ' - ');
                    timeSlotSelect.appendChild(option);
                } else {
                    var option = document.createElement('option');
                    option.value = timeSlots[i];
                    option.textContent = timeSlots[i].replace('-', ' - ');
                    option.disabled = true; // Disable past time slots
                    timeSlotSelect.appendChild(option);
                }
            }
            // Display message for past time slots
            timeSlotMessage.innerHTML = 'Past time slots are disabled.';
        } else {
            // If the selected date is in the future, display all time slots
            for (var j = 0; j < timeSlots.length; j++) {
                var option = document.createElement('option');
                option.value = timeSlots[j];
                option.textContent = timeSlots[j].replace('-', ' - ');
                timeSlotSelect.appendChild(option);
            }
        }
    });
</script>
...

	</body>
</html>