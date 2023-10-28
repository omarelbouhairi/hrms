<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'HR Manager') {
    // Fetch training requests and corresponding employee information
    $query = "SELECT t.*, u.name AS employee_name 
              FROM training AS t 
              JOIN users AS u ON t.user_id = u.id";
    $result = mysqli_query($conn, $query);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Training Request Status</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h2>Training Request Status</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Training Description</th>
                        <th>Training Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['employee_name'] . "</td>";
                        echo "<td>" . $row['training_description'] . "</td>";
                        echo "<td>" . $row['training_date'] . "</td>";
                        echo "<td>";
                        if ($row['status'] == 1) {
                            echo "<span class='badge badge-warning'>Pending</span>";
                        } elseif ($row ['status'] == 2) {
                            echo "<span class='badge badge-success'>Accepted</span>";
                        } elseif ($row['status'] == 3) {
                            echo "<span class='badge badge-danger'>Rejected</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
<?php
} else {
    header("Location: home.php");
    exit();
}
?>
