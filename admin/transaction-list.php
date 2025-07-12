 <?php

$query = "SELECT * FROM (SELECT id, 'Income' AS type, source AS category, amount, created_at FROM income
    UNION ALL
          SELECT id, 'Expense' AS type, category, amount, created_at FROM expenses) AS transactions ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}
?>

