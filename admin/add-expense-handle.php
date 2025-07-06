
<?php 
// add-expense-handle.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

$amount      = $_POST['amount'];
$description = $_POST['description'];

include 'db-conn.php';

$query = "INSERT INTO expenses (amount, description, date_added) VALUES (?, ?, NOW())";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ds", $amount, $description);
mysqli_stmt_execute($stmt);

// Redirect back to the Add Expense page (or to dashboard)
header("Location: dashboard.php?path=add-expense");
exit();
?>
