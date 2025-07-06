<?php
session_start();
$is_LoggedIn = $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
    header("Location: login.php");
    exit();
}

include 'db-conn.php';

$path = 'dashboard'; // this page only shows dashboard

// Fetch data for dashboard
$income_query = "SELECT SUM(amount) AS total_income FROM income";
$expense_query = "SELECT SUM(amount) AS total_expense FROM expenses";

$income_result = mysqli_query($conn, $income_query);
$expense_result = mysqli_query($conn, $expense_query);

$income = mysqli_fetch_assoc($income_result)['total_income'] ?? 0;
$expense = mysqli_fetch_assoc($expense_result)['total_expense'] ?? 0;
$savings = $income - $expense;
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>FinTrack Dashboard</title>
    <link rel="stylesheet" href="src/output.css" />
</head>
<body class="h-full bg-gradient-to-br from-gray-100 via-indigo-100 to-indigo-200 text-gray-900">

    <!-- Navbar -->
<nav class="flex justify-between items-center bg-indigo-700 text-white px-8 shadow-md h-25">
        <!-- Left: Bigger Logo -->
        <div class="flex items-center space-x-4">
            <img src="upload/logo.png" alt="FinTrack Logo" class="h-8 w-auto" />
            <h1 class="font-extrabold text-2xl tracking-wide">Welcome </h1>
        </div>
        <!-- Right: Logout -->
        <a href="logout-handle.php" 
           class=" hover:bg-red-700 transition px-5 py-2 rounded-md font-semibold text-sm shadow-md">
           Logout
        </a>
    </nav>

    <div class="flex h-[calc(100vh-72px)]"> <!-- 72px navbar height -->

        <!-- Sidebar -->
        <aside class="w-60 bg-indigo-900 text-indigo-200 flex flex-col justify-center space-y-5 py-12 px-6">
            <a href="dashboard.php" 
               class="block px-5 py-3 rounded-md cursor-pointer text-indigo-100 hover:bg-indigo-700 hover:text-white font-semibold">
                Dashboard
            </a>
            <a href="add-income.php" 
               class="block px-5 py-3 rounded-md cursor-pointer text-indigo-100 hover:bg-indigo-700 hover:text-white font-semibold">
                Add Income
            </a>
            <a href="add-expense.php" 
               class="block px-5 py-3 rounded-md cursor-pointer text-indigo-100 hover:bg-indigo-700 hover:text-white font-semibold">
                Add Expense
            </a>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-10 overflow-auto">
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
                <h2 class="text-3xl font-bold mb-6 text-indigo-800">💰 Savings</h2>
                <p class="text-5xl font-extrabold text-green-600">
                    Rs. <?php echo number_format($savings, 2); ?>
                </p>
                <div class="mt-8 flex justify-around text-gray-700">
                    <div>
                        <p class="text-sm font-semibold">Total Income</p>
                        <p class="text-xl text-green-700">Rs. <?php echo number_format($income, 2); ?></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold">Total Expense</p>
                        <p class="text-xl text-red-600">Rs. <?php echo number_format($expense, 2); ?></p>
                    </div>
                </div>
            </div>
        </main>

    </div>

</body>
</html>
