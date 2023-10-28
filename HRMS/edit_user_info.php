<?php
session_start();
include "db_conn.php";

$user_data = array( // Initialize the $user_data array with default values
    'id' => '',
    'name' => '',
    'user_address' => '',
    'phone' => '',
    'role' => '',
);

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    // Check if the user has the necessary privileges to edit user information.
    if ($_SESSION['role'] !== 'HR Manager') {
        header("Location: home.php"); // Redirect unauthorized users to the home page.
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user data from the form
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $user_address = $_POST['user_address'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];

        // Update the user's information in the database
        $update_query = "UPDATE users
                        SET name = '$name', user_address = '$user_address', phone = '$phone' , role = '$role'
                        WHERE id = '$user_id'";

        if (mysqli_query($conn, $update_query)) {
            $success_message = "User information has been updated.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }

    // Check if a user ID is provided in the URL
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Fetch the user's current information from the database
        $user_query = "SELECT id, name, user_address, phone , role FROM users WHERE id = '$user_id'";
        $user_result = mysqli_query($conn, $user_query);

        if (mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
        } else {
            $error_message = "User not found.";
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
    <title>Edit User Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit User Information</h2>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        }
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?= $user_data['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="<?= $user_data['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" name="role" required>
                    <option value="Employee"<?= $user_data['role'] === 'Employee' ? ' selected' : '' ?>>Employee</option>
                    <option value="Supervisor"<?= $user_data['role'] === 'Supervisor' ? ' selected' : '' ?>>Supervisor</option>
                    <option value="HR Manager"<?= $user_data['role'] === 'HR Manager' ? ' selected' : '' ?>>HR Manager</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="user_address" class="form-label">Address:</label>
                <input type="text" class="form-control" name="user_address" value="<?= $user_data['user_address'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" name="phone" value="<?= $user_data['phone'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User Information</button>
        </form>
    </div>
</body>
</html>
