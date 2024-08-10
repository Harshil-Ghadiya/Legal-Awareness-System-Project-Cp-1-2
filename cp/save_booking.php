<header>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <!-- Include SweetAlert CSS -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

<!-- Include SweetAlert JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	
	<script>
    function MySucessFn(){
		console.log("Success function called"); // Debugging line
        swal({
            title: "Dear User...Booking Details Saved Successfully",
            text: "",
            type: "success",
            showConfirmButton: true,
        }).then(function() {
			console.log("Redirecting..."); // Debugging line
            window.location='http://localhost/php%20prac/cp/user_dashboard.php';
        });
    }
</script>

</header>
<?php
if(isset($_POST['post'])) {
    // Check if both date and description fields are not empty
    if(!empty($_POST['date']) && !empty($_POST['description'])) {
        // Proceed with saving the booking
        include_once 'db_con/dbCon.php';
        $conn = connect();
        
        $okFlag = TRUE;
        if($okFlag){   
            $date = $_POST['date'];
            $time=$_POST['time_slot'];
            $description = $_POST['description'];
            $client_id = $_POST['client_id'];
            $lawyer_id = $_POST['lawyer_id'];
             
            $conn = connect();
            //Check duplicate value
            
            // sql query for inserting data into database
            $sql = "INSERT INTO `booking`(date,time, description, client_id, lawyer_id, status) VALUES('$date','$time','$description','$client_id','$lawyer_id','Pending')";
            $result=mysqli_query($conn, $sql) or die(mysqli_error ($conn));
            echo "<script type='text/javascript'>MySucessFn();</script>";
        }
    } else {
        // If date or description is empty, display an error message
        echo "<script>alert('Please fill in both date and description fields.');</script>";
    }
}
?>
