<?php
session_start();
if (!$_SESSION['is_loggedin']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    include 'db-conn.php';

    if ($type === 'Income') {
        $query = "DELETE FROM income WHERE id = ?";
    } elseif ($type === 'Expense') {
        $query = "DELETE FROM expenses WHERE id = ?";
    } else {
        
    }

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: dashboard.php?path=dashboard&deleted=1");
    exit();
} else {
    header("Location: dashboard.php?path=dashboard");
    exit();
}
