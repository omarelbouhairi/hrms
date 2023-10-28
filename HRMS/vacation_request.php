<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] === 'HR Manager') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['accept'])) {
            $id_to_accept = $_POST['accept'];
            $accept_query = "UPDATE vacation SET status = 'Accepted' WHERE id = $id_to_accept";
            mysqli_query($conn, $accept_query);
        } elseif (isset($_POST['reject'])) {
            $id_to_reject = $_POST['reject'];
            $reject_query = "UPDATE vacation SET status = 'Rejected' WHERE id = $id_to_reject";
            mysqli_query($conn, $reject_query);
        }
    }

    $fetch_query = "SELECT vacation.*, users.username FROM vacation JOIN users ON vacation.user_id = users.id WHERE vacation.status = 'Pending'";
    $result = mysqli_query($conn, $fetch_query);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>View Vacation Requests</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h2>View Vacation Requests</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($request = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $request['username'] . "</td>";
                        echo "<td>" . $request['vacation_description'] . "</td>";
                        echo "<td>" . $request['vacation_date'] . "</td>";
                        echo "<td>
                                <form method='POST' action='vacation_request.php'>
                                    <input type='hidden' name='accept' value='" . $request['id'] . "'>
                                    <button type='submit' class='btn btn-success'>Accept</button>
                                </form>
                                <form method='POST' action='vacation_request.php'>
                                    <input type='hidden' name='reject' value='" . $request['id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Reject</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="home.php" class="btn btn-primary">Back to home page</a>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
}
