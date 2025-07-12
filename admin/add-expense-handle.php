
<?php 


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
 exit();
}

$amount      = $_POST['amount'];
$category = $_POST['category'];

include 'db-conn.php';

$query = "INSERT INTO expenses( amount, category,  created_at) VALUES (?, ?, NOW())";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ds", $amount, $category);
mysqli_stmt_execute($stmt);

header("Location: dashboard.php?path=add-expense");
exit();
?>
