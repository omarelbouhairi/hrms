<?php
session_start();
include "db_conn.php";
if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
     $sql = mysqli_query($conn, "SELECT training.*, users.name FROM training
     JOIN users ON training.user_id = users.id");
    // Get Update training_id and status
    if (isset($_GET['training_id']) && isset($_GET['status'])) {
        $training_id = $_GET['training_id'];
        $status = $_GET['status'];
        mysqli_query($conn, "update training set status='$status' where training_id='$training_id'");
        header("location: home.php");
        die();
            }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Training Status Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .center-table {
            margin: 0 auto;
        }
    </style>
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
                            <a class="nav-link" href="myinformation.php">
                                My Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reports.php">
                                The Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </li>
                    <?php } else { ?>
                        <!-- For Supervisor and for human resource manager -->
                        <li class="nav-item">
                            <a class="nav-link" href="myinformation.php">
                                My Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="members.php">
                                Members
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reports.php">
                                Create Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="vacations.php">
                                Vacations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="payroll.php">
                                Payroll
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="training.php">
                                Training
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="myinformations.php">
                                View my Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </li>
                        <?php if ($_SESSION['role'] == 'HR Manager') { ?>
                            <!-- Additional options for HR Manager -->
                            <li class="nav-item">
                                <a class="nav-link" href="manage.php">
                                    Manage Employee
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <?php if ($_SESSION['role'] == 'Employee') { ?>
        <div class="col-md-11">
            <div class="center-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Training ID</th>
                            <th>Name</th>
                            <th>Training Description</th>
                            <th>Training Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_assoc($sql)) {
                                ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['training_description'] ?></td>
                                    <td><?php echo $row['training_date'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 1) {
                                            echo "Pending";
                                        } elseif ($row['status'] == 2) {
                                            echo "Accept";
                                        } elseif ($row['status'] == 3) {
                                            echo "Reject";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <select class="form-select" onchange="status_update('<?php echo $row['training_id'] ?>', this.value)">
                                            <option value="">Update Status</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Accept</option>
                                            <option value="3">Reject</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</html>

<?php } else { ?>
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $training_description = $_POST['training_description'];
    $training_date = $_POST['training_date'];
    $status = 1; // Set the status to "Pending" by default.

    // Insert the training record into the database.
    $insert_query = "INSERT INTO training (user_id, training_description, training_date, status) 
                     VALUES ('$user_id', '$training_description', '$training_date', '$status')";

    if (mysqli_query($conn, $insert_query)) {
        // Training record inserted successfully.
        header("Location: training.php"); // Redirect to a page displaying training records.
        exit;
    } else {
        // Handle the case where the insert query fails.
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<h1>Create Training Record</h1>
    <form action="create_training_record.php" method="POST">
        <label for="user_id">Select User:</label>
        <select name="user_id">
            <?php
            // Fetch the list of users from the database
            $user_query = "SELECT id, name FROM users";
            $user_result = mysqli_query($conn, $user_query);

            if ($user_result && mysqli_num_rows($user_result) > 0) {
                while ($user_row = mysqli_fetch_assoc($user_result)) {
                    echo "<option value='" . $user_row['id'] . "'>" . $user_row['name'] . "</option>";
                }
            }
            ?>
        </select><br>
        <label for="training_description">Training Description:</label>
        <textarea name="training_description" rows="4" cols="50"></textarea><br>
        <label for="training_date">Training Date:</label>
        <input type="date" name="training_date"><br>
        <input type="submit" value="Create Training Record">
    </form>

</body>
</html>

    
    ?>
    <?php } ?>
<script type="text/javascript">
    function status_update(training_id, value) {
        let url = "http://localhost/hrms/training.php";
        window.location.href = url + "?training_id=" + training_id + "&status=" + value;
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>