<?php 
   session_start();
   include "db_conn.php";
   if (isset($_SESSION['username']) && isset($_SESSION['id'])) {   
?>
<!DOCTYPE html>
<html>
<head>
    <title>HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-1 d-none d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="home.php">
                                Home
                            </a>
                        </li>
                        <?php if ($_SESSION['role'] == 'Employee') { ?>
                            <!-- FOR Employee -->
                            <li class="nav-item">
                                <a class="nav-link" href="myinfo.php">
                                    My Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="reports.php">
                                    Reports
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="training.php">
                                    Training
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="vacation.php">
                                    Vacations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mysalary.php">
                                    Salary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    Logout
                                </a>
                            </li>
                        <?php } elseif ($_SESSION['role'] == 'Supervisor') { ?>
                            <!-- FOR Supervisor -->
                            <li class="nav-item">
                                <a class="nav-link" href="myinfo.php">
                                    My Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_members.php">
                                    View Employees informations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="create_reports.php">
                                    Reports
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="vacation.php">
                                    Vacations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mysalary.php">
                                    Salary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    Logout
                                </a>
                            </li>
                        <?php } elseif ($_SESSION['role'] == 'HR Manager') { ?>
                            <!-- For HR Manager -->
                            <li class="nav-item">
                                <a class="nav-link" href="myinfo.php">
                                    My Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="create_new_user.php">
                                    Add New User
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="members.php">
                                    Manage Members
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="create_reports.php">
                                    Create Reports
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="create_training.php">
                                    Create Training
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="vacation.php">
                                     Vacations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="payroll.php">
                                    Payroll
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="mysalary.php">
                                    My Salary
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    Logout
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Content for the main area goes here -->
                <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
                    <!-- Your existing content goes here -->
                    <div class="card" style="width: 10rem;">
                        <img src="img/admin-default.png" 
                             class="card-img-top" 
                             alt="image">
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <?= "Hello, " . $_SESSION['name'] ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-5B6OBUw5lC09z3V0JvZFwfN1S5Bq3gGP8D9PTbCvsjz8G4l2fP6PjlCN1jO5lzP9E" crossorigin="anonymous"></script>
</body>
</html>
<?php } else {
    header("Location: index.php");
} ?>
