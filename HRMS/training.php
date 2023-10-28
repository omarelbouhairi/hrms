<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'Employee') {
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = $_GET['id'];
        $status = $_GET['status'];

        // Update the status of the training request in the database
        mysqli_query($conn, "UPDATE training SET status = '$status' WHERE training_id = '$id'");
    }

    // Fetch training requests for the logged-in employee
    $user_id = $_SESSION['id'];
    $training_query = "SELECT training_id, training_description, training_date, status FROM training WHERE user_id = '$user_id'";
    $training_result = mysqli_query($conn, $training_query);
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Training Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Training Requests</h2>
        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>$success_message</div>";
        }
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
               

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Training Description</th>
                    <th>Training Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($training = mysqli_fetch_assoc($training_result)) {
                    echo "<tr>";
                    echo "<td>" . $training['training_description'] . "</td>";
                    echo "<td>" . $training['training_date'] . "</td>";
                    echo "<td>";
                    if ($training['status'] == 1) {
                        echo "Pending";
                    } elseif ($training['status'] == 2) {
                        echo "Accept";
                    } elseif ($training['status'] == 3) {
                        echo "Reject";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<select onchange=\"statusUpdate(this.options[this.selectedIndex].value, " . $training['training_id'] . ")\">";
                    echo "<option value=''>Update Status</option>";
                    echo "<option value='1'>Pending</option>";
                    echo "<option value='2'>Accept</option>";
                    echo "<option value='3'>Reject</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="home.php" class="btn btn-primary">Back to home page</a>
    </div>
    <script>
        function statusUpdate(value, id) {
            let url = "training.php?id=" + id + "&status=" + value;
            window.location.href = url;
            
        }
    </script>
</body>
</html>
