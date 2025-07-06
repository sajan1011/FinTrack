<?php
session_start();
$is_LoggedIn = $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
    header("Location: login.php");
    exit();
}

$path = $_GET['path'] ?? 'dashboard';

include 'db-conn.php';

if ($path === 'dashboard') {
    $income_query = "SELECT SUM(amount) AS total_income FROM income";
    $expense_query = "SELECT SUM(amount) AS total_expense FROM expenses";

    $income_result = mysqli_query($conn, $income_query);
    $expense_result = mysqli_query($conn, $expense_query);

    $income = mysqli_fetch_assoc($income_result)['total_income'] ?? 0;
    $expense = mysqli_fetch_assoc($expense_result)['total_expense'] ?? 0;
    $savings = $income - $expense;
}

// Simple function to add active class for sidebar links
function activeClass($current, $target) {
    return $current === $target 
        ? 'bg-blue-700 border-l-4 border-blue-400 text-white font-semibold' 
        : 'text-blue-200 hover:bg-blue-600 hover:text-white';
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FinTrack Dashboard</title>
    <link rel="stylesheet" href="admin/src/output.css" />
</head>
<body class="h-full bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 text-gray-900">

    <!-- Navbar -->
    <nav class="flex justify-between items-center bg-blue-800 text-white px-6 py-4 shadow-md">
        <!-- Left: Logo -->
        <div class="flex items-center space-x-3">
            <img src="upload/logo.png" alt="FinTrack Logo" class="h-8 w-auto" />
            <h1 class="font-bold text-xl">FinTrack</h1>
        </div>
        <!-- Right: Logout -->
        <a href="logout-handle.php" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-semibold transition">
            Logout
        </a>
    </nav>

    <div class="flex h-[calc(100vh-64px)]"> <!-- height minus navbar height approx 64px -->

        <!-- Sidebar (left middle aligned vertically) -->
        <aside class="w-56 bg-blue-900 text-blue-200 flex flex-col justify-center space-y-3 py-10 px-4">
            <a href="?path=dashboard" class="block px-4 py-3 rounded cursor-pointer <?php echo activeClass($path, 'dashboard'); ?>">
                Dashboard
            </a>
            <a href="?path=add-income" class="block px-4 py-3 rounded cursor-pointer <?php echo activeClass($path, 'add-income'); ?>">
                Add Income
            </a>
            <a href="?path=add-expense" class="block px-4 py-3 rounded cursor-pointer <?php echo activeClass($path, 'add-expense'); ?>">
                Add Expense
            </a>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-8 overflow-auto">
            <?php if ($path === 'dashboard'): ?>
                <div class="max-w-md mx-auto bg-blue-50 rounded-lg shadow-lg p-6 text-center text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">💰 Savings</h2>
                    <p class="text-4xl font-extrabold text-green-600">
                        Rs. <?php echo number_format($savings, 2); ?>
                    </p>
                    <div class="mt-6 flex justify-around text-gray-700">
                        <div>
                            <p class="text-sm font-semibold">Total Income</p>
                            <p class="text-lg text-green-700">Rs. <?php echo number_format($income, 2); ?></p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Total Expense</p>
                            <p class="text-lg text-red-600">Rs. <?php echo number_format($expense, 2); ?></p>
                        </div>
                    </div>
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

</body>
</html>
