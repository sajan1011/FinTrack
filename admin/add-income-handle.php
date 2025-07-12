
<?php 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

$amount      = $_POST['amount'];
$source = $_POST['source'];

include 'db-conn.php';

$query = "INSERT INTO income (amount, source, created_at) VALUES (?, ?, NOW())";
$stmt  = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ds", $amount, $source);
mysqli_stmt_execute($stmt);

header("Location: dashboard.php?path=add-income");
exit();
?>

