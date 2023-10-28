<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'HR Manager') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST['user_id'];
        $training_description = $_POST['training_description'];
        $training_date = $_POST['training_date'];

        // Insert the training request into the 'training' table
        $insert_query = "INSERT INTO training (user_id, training_description, training_date)
                         VALUES ('$user_id', '$training_description', '$training_date')";

        if (mysqli_query($conn, $insert_query)) {
            $success_message = "Training request created successfully.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }

    // Fetch employees from the 'users' table where the role is 'Employee'
    $employees_query = "SELECT id, name FROM users WHERE role = 'Employee'";
    $employees_result = mysqli_query($conn, $employees_query);
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Training Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <nav class="col-md-1 d-none d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                Home
                            </a>
                        </li>
                        <!-- Add other menu items based on the user's role -->
                    </ul>
                </div>
            </nav>
    <div class="container">
        <h2>Create Training Request</h2>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        }
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select Employee:</label>
                <select name="user_id" class="form-select" required>
                    <option value="" disabled selected>Select an Employee</option>
                    <?php
                    while ($employee = mysqli_fetch_assoc($employees_result)) {
                        echo "<option value='" . $employee['id'] . "'>" . $employee['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="training_description" class="form-label">Training Description:</label>
                <input type="text" class="form-control" name="training_description" required>
            </div>
            <div class="mb-3">
                <label for="training_date" class="form-label">Training Date:</label>
                <input type="date" class="form-control" name="training_date" required>
            </div>
            <button type="submit" a href="home.php" class="btn btn-primary">Create Training Request</button>
        </form>
        <a href="view_training_status.php" class="btn btn-success">View Status for all Training Request</a>
    </div>
          

</body>
</html>
