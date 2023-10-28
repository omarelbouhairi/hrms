<?php
session_start();
include "db_conn.php";

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if HR Manager or Supervisor
    if ($_SESSION['role'] == 'HR Manager' || $_SESSION['role'] == 'Supervisor') {
        // Get the selected employee's ID
        $employee_id = $_POST['employee_id']; // Updated from 'id' to 'employee_id'
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['id'];

        // Insert the report into the database
        $sql = "INSERT INTO reports (author_id, employee_id, title, content) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $author_id, $employee_id, $title, $content);
        $stmt->execute();
    }
}

// Fetch and display reports for the employee
$employee_id = $_SESSION['id'];
$reports_sql = "SELECT r.*, u.name AS author_name FROM reports r
                JOIN users u ON r.author_id = u.id
                WHERE r.employee_id = ?";
$stmt = $conn->prepare($reports_sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$reports_result = $stmt->get_result();
?>
<!-- Rest of your HTML code remains unchanged -->
