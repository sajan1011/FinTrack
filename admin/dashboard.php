<?php
session_start();
$is_LoggedIn = $_SESSION['is_loggedin'] ?? true; // Set true for testing without login
if (!$is_LoggedIn) {
    header("Location: login.php");
    exit();
}

include 'db-conn.php';

// Fetch all transactions (income + expenses)
$transactions = [];

$income_sql = "SELECT 'Income' as type, source, amount, created_at FROM income";
$expense_sql = "SELECT 'Expense' as type, category, amount, created_at FROM expenses";
$combined_sql = "$income_sql UNION ALL $expense_sql ORDER BY created_at DESC";

$result = mysqli_query($conn, $combined_sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }
}

// Fetch savings
$income_result = mysqli_query($conn, "SELECT SUM(amount) AS total FROM income");
$expense_result = mysqli_query($conn, "SELECT SUM(amount) AS total FROM expenses");
$total_income = mysqli_fetch_assoc($income_result)['total'] ?? 0;
$total_expense = mysqli_fetch_assoc($expense_result)['total'] ?? 0;
$savings = $total_income - $total_expense;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FinTrack Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
         <link href="src/output.css" rel="stylesheet">

</head>
<body class="bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 min-h-screen">


<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="bg-black w-64 text-white flex flex-col p-4">
        <!-- Logo Area -->
        <div class="h-20 mb-6 flex items-center justify-center border-b border-gray-700">
            <img src="upload/logo.png" alt="Logo" class="h-15">
        </div>

        
        <nav class="flex-1 space-y-4">
            <a href="dashboard.php" class="block px-4 py-2 bg-blue-700 rounded">Dashboard</a>
            <a href="add-income.php" class="block px-4 py-2 hover:bg-gray-800 rounded">Add Income</a>
            <a href="add-expense.php" class="block px-4 py-2 hover:bg-gray-800 rounded">Add Expense</a>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">

        <!-- Top Navbar -->
        <header class="bg-blue-800 text-white flex justify-between items-center px-6 py-4 shadow">
            <h1 class="text-xl font-semibold">💰 Savings: Rs. <?= number_format($savings, 2) ?></h1>
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-medium">
                Logout
            </a>
        </header>

        <!-- Content Area -->
        <main class="p-6 overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4 text-white">All Transactions</h2>
            <div class="bg-white rounded shadow p-4 overflow-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-4 border">S.N</th>
                            <th class="py-2 px-4 border">Type</th>
                            <th class="py-2 px-4 border">Category</th>
                            <th class="py-2 px-4 border">Amount (Rs)</th>
                            <th class="py-2 px-4 border">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No transactions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $index => $tx): ?>
                                <tr class="text-center hover:bg-gray-50">
                                    <td class="border px-4 py-2"><?= $index + 1 ?></td>
                                    <td class="border px-4 py-2"><?= htmlspecialchars($tx['type']) ?></td>
                                    <td class="border px-4 py-2"><?= htmlspecialchars($tx['category']) ?></td>
                                    <td class="border px-4 py-2">Rs. <?= number_format($tx['amount'], 2) ?></td>
                                    <td class="border px-4 py-2"><?= date('Y-m-d', strtotime($tx['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>

    </div>

</div>
</body>
</html>
