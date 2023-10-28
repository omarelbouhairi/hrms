<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if user wants to delete a request
        if (isset($_POST['delete'])) {
            $id_to_delete = $_POST['delete'];
            $delete_query = "DELETE FROM vacation WHERE id = $id_to_delete";
            mysqli_query($conn, $delete_query);
        }
    }

    $fetch_query = "SELECT * FROM vacation WHERE user_id = $user_id";
    $result = mysqli_query($conn, $fetch_query);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Vacation Requests</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h2>Your Vacation Requests</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($request = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $request['vacation_description'] . "</td>";
                        echo "<td>" . $request['vacation_date'] . "</td>";
                        echo "<td>" . $request['status'] . "</td>";
                        echo "<td>
                                <a href='edit_vacation.php?id=" . $request['id'] . "' class='btn btn-warning'>Edit</a>
                                <form method='POST' action='vacation.php'>
                                    <input type='hidden' name='delete' value='" . $request['id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="create_vacation.php" class="btn btn-success">Create a Vacation Request</a>
            <?php if ($_SESSION['role'] == 'HR Manager') { ?>
            <a href="vacation_request.php" class="btn btn-success">View Vacation Request from members</a>
            <?php } ?>
        </div>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
}
?>
