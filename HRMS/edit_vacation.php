<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_to_edit = $_POST['id'];
        $vacation_description = $_POST['vacation_description'];
        $vacation_date = $_POST['vacation_date'];

        $update_query = "UPDATE vacation SET vacation_description = '$vacation_description', vacation_date = '$vacation_date' WHERE id = $id_to_edit";
        mysqli_query($conn, $update_query);

        header("Location: vacation.php");
    } else {
        $id = $_GET['id'];
        $fetch_query = "SELECT * FROM vacation WHERE id = $id";
        $result = mysqli_query($conn, $fetch_query);
        $request = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Vacation Request</title>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container">
                <h2>Edit Vacation Request</h2>
                <form method="post" action="edit_vacation.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="vacation_description">Description</label>
                        <input type="text" class="form-control" name="vacation_description" value="<?php echo $request['vacation_description']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vacation_date">Date</label>
                        <input type="date" class="form-control" name="vacation_date" value="<?php echo $request['vacation_date']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Request</button>
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
        <?php
    }
} else {
    header("Location: index.php");
}
?>
