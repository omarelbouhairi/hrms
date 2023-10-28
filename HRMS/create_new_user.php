<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    // Check if the user has the necessary privileges to add a new user.
    if ($_SESSION['role'] !== 'HR Manager') {
        header("Location: home.php"); // Redirect unauthorized users to the home page.
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security.
        $name = $_POST['name'];
        $user_address = $_POST['user_address'];
        $role = $_POST['role'];
        $phone = $_POST['phone'];

        // Check if the username is unique before inserting the new user.
        $check_username_query = "SELECT username FROM users WHERE username = '$username'";
        $check_username_result = mysqli_query($conn, $check_username_query);

        if (mysqli_num_rows($check_username_result) > 0) {
            // Username is not unique, show an error message.
            $error_message = "Username already exists. Please choose a different one.";
        } else {
            // Insert the new user into the database.
            $insert_query = "INSERT INTO users (username, password, name, user_address, role, phone)
                            VALUES ('$username', '$password', '$name', '$user_address', '$role', '$phone')";

            if (mysqli_query($conn, $insert_query)) {
                header("Location: members.php"); // Redirect to the members page after successful insertion.
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
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

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-4">
                    <h2>Create New User</h2>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'>$error_message</div>";
                    }
                    ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_address" class="form-label">Address:</label>
                            <input type="text" class="form-control" name="user_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role:</label>
                            <select class="form-select" name="role" required>
                                <option value="Employee">Employee</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="HR Manager">HR Manager</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone:</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
