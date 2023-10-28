<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'HR Manager') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process and update salary information to the payroll table
        $user_id = $_POST['user_id'];
        $salary_amount = $_POST['salary_amount'];

        // Insert or update salary information into the payroll table
        $insert_query = "INSERT INTO payroll (user_id, salary_amount, payroll_date)
                         VALUES ('$user_id', '$salary_amount', NOW())
                         ON DUPLICATE KEY UPDATE salary_amount = '$salary_amount', payroll_date = NOW()";

        if (mysqli_query($conn, $insert_query)) {
            $success_message = "Salaries updated successfully.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }

    // Fetch the list of users to display in the form
    $users_query = "SELECT id, name FROM users";
    $users_result = mysqli_query($conn, $users_query);

} else {
    header("Location: home.php"); // Redirect unauthorized users to the home page.
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payroll - HR Manager</title>
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
        <h2>Payroll - HR Manager</h2>
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
                <label for="user_id" class="form-label">Select User:</label>
                <select name="user_id" class="form-select">
                    <?php
                    while ($user_row = mysqli_fetch_assoc($users_result)) {
                        echo "<option value='" . $user_row['id'] . "'>" . $user_row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="salary_amount" class="form-label">Salary Amount:</label>
                <input type="text" class="form-control" name="salary_amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Salary</button>
        </form>
    </div>
</body>
</html>
