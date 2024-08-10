<?php
session_start();

// Check if the user is logged in and has an active session
if (isset($_SESSION['login']) && $_SESSION['login'] === TRUE && isset($_SESSION['status']) && $_SESSION['status'] === 'Active') {
    include("db_con/dbCon.php");
    // Ensure client_id is correctly set
    if (!isset($_SESSION['client_id'])) {
        die("Client ID not set in session.");
    }
    $client_id = $_SESSION['client_id'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/simple-sidebar.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <title>Lawyer Management System</title>
</head>
<body>
    <header class="customnav bg-success">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg ">
                        <a class="navbar-brand cus-a" href="index.php">Lawyer Management System</a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto ">
                                <li class="">
                                    <a class="nav-link cus-a" href="logout.php">Log Out</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">My Profile</div>
            <div class="list-group list-group-flush">
                <a href="user_dashboard.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="lawyerfind.php" class="list-group-item list-group-item-action bg-light">Lawyers</a>
                <a href="user_profile.php" class="list-group-item list-group-item-action bg-light">Edit Profile</a>
                <a href="user_booking.php" class="list-group-item list-group-item-action bg-light">My booking requests</a>
                <a href="update_password.php" class="list-group-item list-group-item-action bg-light">Update Password</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <section class="bookingrqst">
            <div class="container">
                <div class="span7">   
                    <div class="widget stacked widget-table action-table">
                        <div class="widget-header">
                            <i class="icon-th-list"></i>
                            <h3>Booking Request</h3>
                        </div> <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered table-success table-responsive">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Lawyer Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
    <?php
    $conn = connect();
    $result = mysqli_query($conn, "SELECT booking_id, first_Name, last_Name, date, description, booking.status as statuss
        FROM booking
        JOIN lawyer ON booking.lawyer_id = lawyer.lawyer_id
        JOIN user ON lawyer.lawyer_id = user.u_id 
        WHERE booking.client_id = '$client_id'");
    
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }
    
    $counter = 0;
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <tr id="booking-<?php echo $row['booking_id']; ?>">
            <td><?php echo ++$counter; ?></td>
            <td><?php echo htmlspecialchars($row["date"]); ?></td>
            <td><?php echo htmlspecialchars($row["description"]); ?></td>
            <td><?php echo htmlspecialchars($row["first_Name"] . " " . $row["last_Name"]); ?></td>
            <td>
                <?php echo htmlspecialchars($row["statuss"]); ?>
                <?php if ($row["statuss"] !== 'Canceled' && $row["statuss"] !== 'Declined') { ?>
                    <button class="btn btn-danger cancel-booking" data-booking-id="<?php echo $row['booking_id']; ?>">Cancel</button>
                <?php } else { ?>
                    <button class="btn btn-secondary close-row" data-booking-id="<?php echo $row['booking_id']; ?>">×</button>
                <?php } ?>
            </td>    
        </tr>
    <?php } ?>
</tbody>

                            </table>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div>
            </div>
        </section>
    </div>
    <!-- /#wrapper -->

    <footer class="bg-success">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>All rights reserved 2022</h5>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    // Handle cancel booking click event
    $(".cancel-booking").click(function() {
        var bookingId = $(this).data("booking-id");
        if (confirm("Are you sure you want to cancel this booking?")) {
            $.ajax({
                url: "cancel_booking.php",
                method: "POST",
                data: { bookingId: bookingId },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        // Update the status cell to 'Canceled'
                        $("#booking-" + bookingId).find("td:nth-child(5)").text("Canceled");
                        // Remove the cancel button and add the close button
                        $("#booking-" + bookingId).find(".cancel-booking").remove();
                        $("#booking-" + bookingId).find("td:nth-child(5)").append('<button class="btn btn-secondary close-row" data-booking-id="' + bookingId + '">×</button>');
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Handle close row click event
    $(document).on("click", ".close-row", function() {
        var bookingId = $(this).data("booking-id");
        $("#booking-" + bookingId).remove();
    });
});
</script>
</body>
</html>       
<?php
} else {
    header('location:login.php?deactivate');
}
?>
