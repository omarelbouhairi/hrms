<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'Employee') {
    // Fetch reports related to the logged-in employee
    $employee_id = $_SESSION['id'];
    $reports_query = "SELECT r.title, r.content, u.name as author_id, r.created_at
                     FROM reports r
                     INNER JOIN users u ON r.author_id = u.id
                     WHERE r.employee_id = '$employee_id'";
    $reports_result = mysqli_query($conn, $reports_query);
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports About Me</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>My Reports</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created By</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($report = mysqli_fetch_assoc($reports_result)) {
                    echo "<tr>";
                    echo "<td>" . $report['title'] . "</td>";
                    echo "<td>" . $report['content'] . "</td>";
                    echo "<td>" . $report['author_id'] . "</td>";
                    echo "<td>" . $report['created_at'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="home.php" class="btn btn-primary">Back to home page</a>
    </div>
</body>
</html>
