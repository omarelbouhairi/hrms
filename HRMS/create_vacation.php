<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vacation_description = $_POST['vacation_description'];
        $vacation_date = $_POST['vacation_date'];
        $user_id = $_SESSION['id'];
        $status = 'Pending';

        $insert_query = "INSERT INTO vacation (user_id, vacation_description, vacation_date, status) VALUES ('$user_id', '$vacation_description', '$vacation_date', '$status')";
        mysqli_query($conn, $insert_query);

        header("Location: vacation.php");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Create Vacation Request</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h2>Create a Vacation Request</h2>
            <form method="post" action="create_vacation.php">
                <div class="form-group">
                    <label for="vacation_description">Description</label>
                    <input type="text" class="form-control" name="vacation_description" required>
                </div>
                <div class="form-group">
                    <label for="vacation_date">Date</label>
                    <input type="date" class="form-control" name="vacation_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
}
