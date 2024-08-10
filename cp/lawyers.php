<?php
include_once 'db_con/dbCon.php';
$conn = connect();

$results_per_page = 3; // number of results per page

// Retrieve search parameters if set
$name = isset($_GET['name']) ? $_GET['name'] : '';
$experience = isset($_GET['experience']) ? $_GET['experience'] : '';
$speciality = isset($_GET['speciality']) ? $_GET['speciality'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Base SQL query
$query = "SELECT * FROM user, lawyer WHERE user.u_id = lawyer.lawyer_id AND user.status = 'Active'";

// Add search parameters to the query
if (!empty($name)) {
    $query .= " AND (first_Name LIKE '%$name%' OR last_Name LIKE '%$name%')";
}
if (!empty($experience)) {
    $query .= " AND practise_Length = '$experience'";
}
if (!empty($speciality)) {
    $query .= " AND speciality = '$speciality'";
}
if (!empty($location)) {
    $query .= " AND city = '$location'";
}

// Get total number of results
$total_query = str_replace("SELECT *", "SELECT COUNT(*) AS total", $query);
$result = mysqli_query($conn, $total_query);
$row = mysqli_fetch_assoc($result);
$total_results = $row['total'];

// Determine total number of pages available
$total_pages = ceil($total_results / $results_per_page);

// Determine which page number visitor is currently on
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Determine the starting limit number
$start_limit = ($page - 1) * $results_per_page;

// Add limit to the query
$query .= " LIMIT $start_limit, $results_per_page";

$result = mysqli_query($conn, $query);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7U2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
                    <nav class="navbar navbar-expand-lg ">
                        <a class="navbar-brand cus-a" href="index.php">Lawyer Management System</a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="">
                                    <a class="nav-link cus-a" href="search_law.php">Laws</a>
                                </li>
                                <li class="">
                                    <a class="nav-link cus-a" href="lawyers.php">Lawyers</a>
                                </li>
                                <?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE){ ?>
                                    <li class="">
                                        <a class="nav-link cus-a" href="user_dashboard.php">Dashboard</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link cus-a" href="logout.php">Logout</a>
                                    </li>
                                <?php } else { ?>
                                    <li class="">
                                        <a class="nav-link cus-a" href="login.php">Login</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle cus-a" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Register
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="lawyer_register.php">Register as a lawyer</a>
                                            <a class="dropdown-item" href="user_register.php">Register as a user</a>
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

    <div class="" id="wrapper">
        <section class="">
            <div class="container">
                <br/>
                <form method="get" novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Lawyer's Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter lawyer's name" value="<?php echo htmlspecialchars($name); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="experience">Experience</label>
                                <select name="experience" class="form-control">
                                    <option value="" <?php if($experience == '') echo 'selected'; ?>>Choose...</option>
                                    <option value="1-5 years" <?php if($experience == '1-5 years') echo 'selected'; ?>>1-5 years</option>
                                    <option value="6-10 years" <?php if($experience == '6-10 years') echo 'selected'; ?>>6-10 years</option>
                                    <option value="11-15 years" <?php if($experience == '11-15 years') echo 'selected'; ?>>11-15 years</option>
                                    <option value="16-20 years" <?php if($experience == '16-20 years') echo 'selected'; ?>>16-20 years</option>
                                    <option value="Most Senior" <?php if($experience == 'Most Senior') echo 'selected'; ?>>Most Senior</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="speciality">Speciality</label>
                                <select name="speciality" class="form-control">
                                    <option value="" <?php if($speciality == '') echo 'selected'; ?>>Choose...</option>
                                    <option value="Criminal law" <?php if($speciality == 'Criminal law') echo 'selected'; ?>>Criminal law</option>
                                    <option value="Civil law" <?php if($speciality == 'Civil law') echo 'selected'; ?>>Civil law</option>
                                    <option value="Writ Jurisdiction" <?php if($speciality == 'Writ Jurisdiction') echo 'selected'; ?>>Writ Jurisdiction</option>
                                    <option value="Company law" <?php if($speciality == 'Company law') echo 'selected'; ?>>Company law</option>
                                    <option value="Contract law" <?php if($speciality == 'Contract law') echo 'selected'; ?>>Contract law</option>
                                    <option value="Commercial law" <?php if($speciality == 'Commercial law') echo 'selected'; ?>>Commercial law</option>
                                    <option value="Construction law" <?php if($speciality == 'Construction law') echo 'selected'; ?>>Construction law</option>
                                    <option value="IT law" <?php if($speciality == 'IT law') echo 'selected'; ?>>IT law</option>
                                    <option value="Family law" <?php if($speciality == 'Family law') echo 'selected'; ?>>Family law</option>
                                    <option value="Religious law" <?php if($speciality == 'Religious law') echo 'selected'; ?>>Religious law</option>
                                    <option value="Investment law" <?php if($speciality == 'Investment law') echo 'selected'; ?>>Investment law</option>
                                    <option value="Labour law" <?php if($speciality == 'Labour law') echo 'selected'; ?>>Labour law</option>
                                    <option value="Property law" <?php if($speciality == 'Property law') echo 'selected'; ?>>Property law</option>
                                    <option value="Taxation law" <?php if($speciality == 'Taxation law') echo 'selected'; ?>>Taxation law</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="location">Location</label>
                            <select name="location" class="form-control">
                                <option value="" <?php if($location == '') echo 'selected'; ?>>Choose...</option>
                                <option value="karachi" <?php if($location == 'karachi') echo 'selected'; ?>>karachi</option>
                                <option value="lahore" <?php if($location == 'lahore') echo 'selected'; ?>>lahore</option>
                                <option value="islamabad" <?php if($location == 'islamabad') echo 'selected'; ?>>islamabad</option>
                                <option value="multan" <?php if($location == 'multan') echo 'selected'; ?>>multan</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <hr/>

                <div class="row">
                    <?php
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="images/upload/<?php echo $row["image"]; ?>" class="card-img-top cusimg img-fluid" alt="img">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["first_Name"]; ?> <?php echo $row["last_Name"]; ?></h5>
                                <h6 class="card-title"><?php echo $row["speciality"]; ?></h6>
                                <h6 class="card-title"><span><?php echo $row["practise_Length"]; ?></span></h6>
                                <a class="btn btn-sm btn-info" href="single_lawyer.php?u_id=<?php echo $row["u_id"]; ?>"><i class="fa fa-street-view"></i>&nbsp; View Full Profile</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="lawyers.php?page=<?php echo $page - 1; ?>&name=<?php echo urlencode($name); ?>&experience=<?php echo urlencode($experience); ?>&speciality=<?php echo urlencode($speciality); ?>&location=<?php echo urlencode($location); ?>">Previous</a></li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="lawyers.php?page=<?php echo $i; ?>&name=<?php echo urlencode($name); ?>&experience=<?php echo urlencode($experience); ?>&speciality=<?php echo urlencode($speciality); ?>&location=<?php echo urlencode($location); ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="lawyers.php?page=<?php echo $page + 1; ?>&name=<?php echo urlencode($name); ?>&experience=<?php echo urlencode($experience); ?>&speciality=<?php echo urlencode($speciality); ?>&location=<?php echo urlencode($location); ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>

            </div>
        </section>
    </div>

    <footer class="bg-success">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>All rights reserved. 2023</h5>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
