<?php
session_start();
if($_SESSION['login'] == TRUE AND $_SESSION['status'] == 'Active') {
    include("db_con/dbCon.php");

    $conn = connect();
    $results_per_page = 3; // number of results per page

    // Find out the number of results stored in the database
    $sql = "SELECT COUNT(*) AS total FROM user, lawyer WHERE user.u_id=lawyer.lawyer_id AND user.status='Active'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_results = $row['total'];

    // Determine total number of pages available
    $total_pages = ceil($total_results / $results_per_page);

    // Determine which page number visitor is currently on
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

    // Determine the starting limit number
    $start_limit = ($page - 1) * $results_per_page;

    // Retrieve selected results from the database and display them on the page
    $sql = "SELECT * FROM user, lawyer WHERE user.u_id=lawyer.lawyer_id AND user.status='Active' LIMIT $start_limit, $results_per_page";
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
    <title>Legal Awareness System</title>
</head>
<body>
    <header class="customnav bg-success">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand cus-a" href="index.php">Legal Awareness System</a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
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
    <body>
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

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <?php if(isset($_GET['done'])): ?>
                    <div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        <strong>Welcome!</strong> You are logged in as a user.
                    </div>
                <?php endif; ?>

                <div class="" id="wrapper">
                    <section class="">
                        <div class="container">
                            <br/>
                            <a href="findlawyer2.php" type="submit" class="btn btn-md btn-primary "><i class="fa fa-search"></i>&nbsp; Find Lawyer</a>
                            <hr/>
                            <div class="row">
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <div class="col-md-4">
                                        <div class="card" style="width: 18rem;">
                                            <img src="images/upload/<?php echo $row["image"]; ?>" class="card-img-top cusimg img-fluid" alt="img">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row["first_Name"]; ?> <?php echo $row["last_Name"]; ?></h5>
                                                <h6 class="card-title"><?php echo $row["speciality"]; ?></h6>
                                                <h6 class="card-title"><span><?php echo $row["practise_Length"]; ?></span></h6>
                                                <a class="btn btn-sm btn-info" href="lawyerfind1.php?u_id=<?php echo $row["u_id"]; ?>"><i class="fa fa-street-view"></i>&nbsp; View Full Profile</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="lawyerfind.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="lawyerfind.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="lawyerfind.php?page=<?php echo $page + 1; ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

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
<?php
} else {
    header('location:login.php?deactivate');
}
?>
