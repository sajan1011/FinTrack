<?php
session_start();
if (!$_SESSION['is_loggedin']) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Expense</title>
    <link rel="stylesheet" href="src/output.css">
</head>
<body class="bg-blue-100">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">Add Expense</h2>
        <form action="add-expense-handle.php" method="POST" class="space-y-4">
            <input type="text" name="source" placeholder="Category" required class="w-full px-4 py-2 border rounded" />
            <input type="number" name="amount" placeholder="Amount (Rs)" required class="w-full px-4 py-2 border rounded" />
            <input type="date" name="date" required class="w-full px-4 py-2 border rounded" />
            <textarea name="note" placeholder="Note (optional)" class="w-full px-4 py-2 border rounded"></textarea>
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">Add Expense</button>
        </form>
    </div>
</body>
</html>
