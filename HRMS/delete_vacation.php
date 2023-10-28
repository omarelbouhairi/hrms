<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_to_delete = $_POST['id'];
        $delete_query = "DELETE FROM vacation WHERE id = $id_to_delete";
        mysqli_query($conn, $delete_query);

        header("Location: vacation.php");
    }
} else {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Vacation Request</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Delete Vacation Request</h2>
        <p>Are you sure you want to delete this vacation request?</p>
        <form method="post" action="delete_vacation.php">
            <input type="hidden" name="id" value="<?php echo $id_to_delete; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="vacation.php" class="btn btn-secondary">Cancel</a>
        </form>
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
