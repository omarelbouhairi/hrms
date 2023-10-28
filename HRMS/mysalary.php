<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Retrieve the user's salary information
    $salary_query = "SELECT salary_amount, payroll_date FROM payroll WHERE user_id = '$user_id'";
    $salary_result = mysqli_query($conn, $salary_query);

    if (mysqli_num_rows($salary_result) > 0) {
        $salary_data = mysqli_fetch_assoc($salary_result);
        $salary_amount = $salary_data['salary_amount'];
        $payroll_date = $salary_data['payroll_date'];
    } else {
        $error_message = "Salary information not found.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>My Salary</h2>
        <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <div class="mb-3">
            <label for="salary_amount" class="form-label">Salary Amount:</label>
            <input type="text" class="form-control" name="salary_amount" value="<?= isset($salary_amount) ? $salary_amount : 'N/A' ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="payroll_date" class="form-label">Payroll Date:</label>
            <input type="text" class="form-control" name="payroll_date" value="<?= isset($payroll_date) ? $payroll_date : 'N/A' ?>" readonly>
        </div>
        <a href="home.php" class="btn btn-primary">Back to home page</a>
    </div>
</body>
</html>
