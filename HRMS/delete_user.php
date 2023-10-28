<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    if ($_SESSION['role'] === 'HR Manager') {
        // Check if the user_id is provided in the URL.
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            
            // Prepare a SQL query to delete the user with the specified ID.
            $delete_query = "DELETE FROM users WHERE id = $user_id";
            
            if (mysqli_query($conn, $delete_query)) {
                // User deleted successfully.
                header("Location: members.php");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        } else {
            $error_message = "User ID not provided.";
        }
    } else {
        header("Location: home.php"); // Redirect unauthorized users to the home page.
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
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
                        <li class="nav-item">
                            <a class="nav-link" href="members.php">
                                Members
                            </a>
                        </li>
                        <!-- Add other menu items based on the user's role -->
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-4">
                    <h2>Delete User</h2>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'>$error_message</div>";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
