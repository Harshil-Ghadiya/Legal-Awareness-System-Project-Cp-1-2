<?php
session_start();
if ($_SESSION['login'] == TRUE AND $_SESSION['status'] == 'Active') {

    include("db_con/dbCon.php");

    $conn = connect();
    $lawyer_id = $_SESSION['lawyer_id'];

    // Get the selected date or default to today's date
    $selected_date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

    $sql = "SELECT * FROM booking WHERE lawyer_id = '$lawyer_id' AND date = '$selected_date' ORDER BY time";
    $result = mysqli_query($conn, $sql);
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
        <title>Lawyer Schedule</title>
    </head>
    <body>
        <header class="customnav bg-success">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg ">
                            <a class="navbar-brand cus-a" href="index.php">Legal Awareness System</a>
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
                    <a href="lawyer_dashboard.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                    <a href="lawyer_edit_profile.php" class="list-group-item list-group-item-action bg-light">Edit Profile</a>
                    <a href="lawyer_booking.php" class="list-group-item list-group-item-action bg-light">Booking requests</a>
                    <a href="lawyer_schedule.php" class="list-group-item list-group-item-action bg-light">My Schedule</a>
                    <a href="update_password_admin.php" class="list-group-item list-group-item-action bg-light">Update Password</a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <h1 class="mt-4">Schedule</h1>
                    <form method="post" action="lawyer_schedule.php">
                        <div class="form-group">
                            <label for="date">Select Date:</label>
                            <input type="date" id="date" name="date" class="form-control" value="<?php echo $selected_date; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">View Schedule</button>
                    </form>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . date('h:i A', strtotime($row['time'])) . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No appointments for the selected date</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <footer>
            <div class="container bg-success">
                <div class="row">
                    <div class="col">
                        <h5>All rights reserved 2022</h5>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </body>
</html>
<?php
} else {
    header('location:login.php?deactivate');
}
?>
