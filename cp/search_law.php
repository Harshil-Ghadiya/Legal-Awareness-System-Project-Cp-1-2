<?php
session_start();
require_once("db_con/dbCon.php");
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
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
		</style>
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
                            <form class="form-inline my-2 my-lg-0" action="search_law.php" method="GET">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query" style="background-color: rgba(255, 255, 255, 0.5);">
                                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                            </form>
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
<body>
    <div class="container">
        <?php
        $conn = connect();
        if (isset($_GET["query"])) {
            $query = $_GET["query"];

            $sql = "SELECT * FROM `search` WHERE `Law_Name` LIKE ? OR `Category` LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $query . "%";
            $stmt->bind_param('ss', $searchTerm, $searchTerm);

            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo '<br><br><br><table class="table table-striped">';
                echo '<thead><tr><th>Law Name</th><th>Law Description</th><th>Category</th></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['Law_Name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Law_Description']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Category']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>No matching law found.</p>';
            }
            $stmt->close();
        } else {
            echo '<p>Please enter a search query.</p>';
        }
        ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-ByfVr1LFtNp7frtXg5c6C4FnUEy5EVKxP4LgYsD6Zb5zTTEKq7pJc3BLy4qpy5Yr" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdH8VB6j1Qpe9fYZ1BJLhr0+p6Kzt043AT5VVPZz65f1mI4eI4Q2CKQI6sI6" crossorigin="anonymous"></script>
</body>
</html>
