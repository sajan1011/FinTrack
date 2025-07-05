<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: login.php');
    exit();
}

$user_email = $_POST['email'];
$user_password = $_POST['password'];

include 'db-conn.php'; // database connection

// 1. Prepare SQL
$query = "SELECT * FROM admin WHERE email=? AND password=?";
$mysql_stmt = mysqli_prepare($conn, $query);

// 2. Bind parameters
mysqli_stmt_bind_param($mysql_stmt, 'ss', $user_email, $user_password);

// 3. Execute
mysqli_stmt_execute($mysql_stmt);

// 4. Get result
$mysql_result = mysqli_stmt_get_result($mysql_stmt);

// 5. Fetch result
$data = mysqli_fetch_assoc($mysql_result);

// 6. Check if user exists
if ($data) {
    session_start();
    $_SESSION['is_loggedin'] = true;
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php?error=email or password incorrect");
    exit();
}
?>
