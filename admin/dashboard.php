<?php
session_start();
$is_LoggedIn = $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
    header("Location: login.php");
    exit();
}

$path = $_GET['path'] ?? 'dashboard';

include 'db-conn.php';

// Fetch total income, expense, savings
if ($path === 'dashboard') {
    $income_query = "SELECT SUM(amount) AS total_income FROM income";
    $expense_query = "SELECT SUM(amount) AS total_expense FROM expenses";

    $income_result = mysqli_query($conn, $income_query);
    $expense_result = mysqli_query($conn, $expense_query);

    $income = mysqli_fetch_assoc($income_result)['total_income'] ?? 0;
    $expense = mysqli_fetch_assoc($expense_result)['total_expense'] ?? 0;
    $savings = $income - $expense;

    // Fetch all transactions
    $tx_query = "SELECT * FROM (SELECT id, 'Income' AS type, source AS category, amount, created_at FROM income
                    UNION ALL
                SELECT id, 'Expense' AS type, category, amount, created_at FROM expenses) AS transactions ORDER BY created_at DESC";
    $tx_result = mysqli_query($conn, $tx_query);

    $data= [];
    while ($row = mysqli_fetch_assoc($tx_result)) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FinTrack Dashboard</title>
    <link rel="stylesheet" href="src/output.css" />
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-60 bg-gray-300 border-r shadow-gray-500 border-gray-200 flex flex-col px-4 py-8 space-y-4 text-sm">
    <div class="flex-shrink-0 mb-6 flex justify-center">
      <img src="upload/logo.png" alt="FinTrack Logo" class="h-24 w-auto object-contain" />
    </div>

    <!-- Dashboard -->
    <a href="?path=dashboard" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-200 <?= $path === 'dashboard' ? 'bg-gray-100 font-semibold' : '' ?>">
      <!-- Dashboard icon -->
      <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 4v6m-4-6v6M5 10v10h14V10" />
      </svg>
      <span>Dashboard</span>
    </a>

    <!-- Add Income (+) -->
    <a href="?path=add-income" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-200 <?= $path === 'add-income' ? 'bg-gray-300 font-semibold' : '' ?>">
      <!-- Plus icon -->
      <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      <span>Add Income</span>
    </a>

    <!-- Add Expense (-) -->
    <a href="?path=add-expense" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-200 <?= $path === 'add-expense' ? 'bg-gray-300 font-semibold' : '' ?>">
      <!-- Minus icon -->
      <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
      </svg>
      <span>Add Expense</span>
    </a>
  </aside>

  <!-- Main: navbar + content -->
  <div class="flex flex-col flex-1">
    <nav class="flex justify-between items-center bg-white shadow px-6 py-4 border-b border-gray-200">
      <h1 class="text-lg font-semibold text-gray-700">💰 Savings: Rs. <?= number_format($savings, 2) ?></h1>
      <a href="logout-handle.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm font-medium">
        Logout
      </a>
    </nav>

    <main class="flex-1 p-8 overflow-y-auto">
      <?php if ($path === 'dashboard'): ?>
          <h2 class="text-2xl font-bold text-center mb-6">All Transactions 🧾</h2>
          <div class="overflow-x-auto">
              <table class="w-full bg-white rounded-lg shadow text-sm text-left">
                  <thead class="bg-gray-200 text-gray-700">
                      <tr>
                          <th class="px-6 py-3 text-center">S.N</th>
                          <th class="px-6 py-3 text-center">Type</th>
                          <th class="px-6 py-3 text-center">Category/Source</th>
                          <th class="px-6 py-3 text-center">Amount (Rs)</th>
                          <th class="px-6 py-3 text-center">Date</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if (count($data) > 0): ?>
                          <?php foreach ($data as $index => $tx): ?>
                              <tr class="text-center border-t hover:bg-gray-50">
                                  <td class="py-2 px-4 border"><?= $index + 1 ?></td>
                                  <td class="py-2 px-4 border font-semibold"><?= htmlspecialchars($tx['type']) ?></td>
                                  <td class="py-2 px-4 border"><?= htmlspecialchars($tx['category']) ?></td>
                                  <td class="py-2 px-4 border">Rs. <?= number_format($tx['amount'], 2) ?></td>
                                  <td class="py-2 px-4 border"><?= date('Y-m-d', strtotime($tx['created_at'])) ?></td>
                              </tr>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <tr>
                              <td colspan="5" class="text-center py-4">No transactions found.</td>
                          </tr>
                      <?php endif; ?>
                  </tbody>
              </table>
          </div>
      <?php elseif ($path === 'add-income'): ?>
          <?php include 'add-income.php'; ?>
      <?php elseif ($path === 'add-expense'): ?>
          <?php include 'add-expense.php'; ?>
      <?php else: ?>
          <p class="text-center text-red-600 font-semibold">Page Not Found</p>
      <?php endif; ?>
    </main>
  </div>
</div>

</body>
</html>
