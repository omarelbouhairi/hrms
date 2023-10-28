<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && ($_SESSION['role'] == 'HR Manager' || $_SESSION['role'] == 'Supervisor')) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $employee_id = $_POST['employee_id'];

        // Insert the report intothe reports table
        $insert_query = "INSERT INTO reports (title, content, employee_id, author_id)
                         VALUES ('$title', '$content', '$employee_id', '" . $_SESSION['id'] . "')";

        if (mysqli_query($conn, $insert_query)) {
            $success_message = "Report created successfully.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }

    // Fetch a list of employees (users with the role 'Employee')
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
    <title>Create Report</title>
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
        <h2>Create Report</h2>
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
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" name="content" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="employee_id" class="form-label">Select Employee:</label>
                <select name="employee_id" class="form-select" required>
                    <?php
                    while ($employee_row = mysqli_fetch_assoc($employees_result)) {
                        echo "<option value='" . $employee_row['id'] . "'>" . $employee_row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Report</button>
        </form>
    </div>
</body>
</html>
