<?php
session_start();
if ($_SESSION['login'] == TRUE && $_SESSION['status'] == 'Active') {

    include("db_con/dbCon.php");
    $conn = connect();

    if (isset($_GET['unblock_id'])) {
        $id = $_GET['unblock_id'];
        $sql = "UPDATE `booking` SET `status`='Accepted' WHERE booking_id='$id'";
        $conn->query($sql);
        header("Location:lawyer_booking.php");
        exit;
    }

    if (isset($_GET['decline_id'])) {
        $id = $_GET['decline_id'];
        $sql = "UPDATE `booking` SET `status`='Declined' WHERE booking_id='$id'";
        $conn->query($sql);
        header("Location:lawyer_booking.php");
        exit;
    }
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
        <title>Booking Requests</title>
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
                    <a href="update_password_admin.php" class="list-group-item list-group-item-action bg-light">Update Password</a>
                    <a href="lawyer_schedule.php" class="list-group-item list-group-item-action bg-light">My Schedule</a>
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
                            </div>
                            <div class="widget-content">
                                <table class="table table-striped table-bordered  table-success table-responsive">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Client Name</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    include_once 'db_con/dbCon.php';
                                    $a = $_SESSION['lawyer_id'];
                                    $conn = connect();
                                    $result = mysqli_query($conn, "SELECT booking_id, first_Name, last_Name, date, description, booking.status as 'statuss' 
                                                                   FROM booking, client, user 
                                                                   WHERE booking.client_id=client.client_id 
                                                                   AND client.client_id=user.u_id AND booking.lawyer_id='$a'");
                                    $counter = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <tbody id="myTable">
                                            <tr>
                                                <td><?php echo ++$counter; ?></td>
                                                <td><?php echo $row["first_Name"] . ' ' . $row["last_Name"]; ?></td>
                                                <td><?php echo $row["date"]; ?></td>
                                                <td><?php echo $row["description"]; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row['statuss'] == 'Pending') {
                                                        ?>
                                                        <a class="btn btn-sm btn-warning" href="lawyer_booking.php?unblock_id=<?= $row['booking_id'] ?>"><i class="fas fa-hourglass"></i>&nbsp; Pending</a>
                                                        <a class="btn btn-sm btn-danger" href="lawyer_booking.php?decline_id=<?= $row['booking_id'] ?>"><i class="fas fa-times"></i>&nbsp; Decline</a>
                                                        <?php
                                                    } elseif ($row['statuss'] == 'Declined') {
                                                        echo "Declined";
                                                    } elseif ($row['statuss'] == 'Canceled') {
                                                        echo "Canceled";
                                                    } else {
                                                        echo "Active";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </body>
    <footer class="bg-success">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>All rights reserved 2022</h5>
                </div>
            </div>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</html>
<?php
} else {
    header('location:login.php?deactivate');
}
?>
