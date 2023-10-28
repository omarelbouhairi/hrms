<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Retrieve the user's information
    $user_query = "SELECT id, username, name, user_address, role, phone FROM users WHERE id = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);

    if (mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
    } else {
        $error_message = "User information not found.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>My Information</h2>
        <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" value="<?= $user_data['username'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="<?= $user_data['name'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="user_address" class="form-label">Address:</label>
            <input type="text" class="form-control" name="user_address" value="<?= $user_data['user_address'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role:</label>
            <input type="text" class="form-control" name="role" value="<?= $user_data['role'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" name="phone" value="<?= $user_data['phone'] ?>" readonly>
        </div>
        <a href="home.php" class="btn btn-primary">Back to home page</a>
    </div>
</body>
</html>
