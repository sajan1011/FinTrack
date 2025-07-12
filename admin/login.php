<?php
session_start();
if ($_SESSION['is_loggedin'] ?? false) {
  header("Location: dashboard.php");
  exit();
}
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinTrack Login</title>
  <link href="src/output.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-r from-[#e2e6ec] to-[#9a9dd8] h-screen flex items-center justify-center">

  <div class="w-[70%] max-w-5xl h-[500px] bg-white shadow-2xl rounded-3xl overflow-hidden flex relative">

    <div class="w-[50%] p-10 flex flex-col justify-center z-10">
      <div class="flex justify-center mb-6">
        <img src="upload/logo.png" alt="FinTrack Logo" class="h-20">
      </div>
      <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Welcome Back!</h2>
      <p class="text-sm text-center text-gray-500 mb-6">Login to manage your finances</p>

      <?php if ($error): ?>
        <div class="mb-4 text-sm text-red-600 bg-red-100 px-4 py-2 rounded">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form action="login-handle.php" method="POST" class="space-y-4">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm" />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" id="password" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 text-sm" />
        </div>

        <button type="submit"
          class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition text-sm font-semibold">
          LOG IN
        </button>
      </form>
    </div>

    <div class="w-[50%] bg-gradient-to-br from-indigo-500 via-indigo-600 to-indigo-700 flex flex-col justify-center items-center text-white p-6 rounded-l-[100px]">
      <h2 class="text-3xl font-bold mb-3 text-center">Welcome to FinTrack</h2>
      <p class="text-sm text-indigo-100 text-center leading-relaxed">
        Track your income, control expenses,<br> and grow your savings — all in one place.
      </p>
    </div>
    
  </div>

</body>
</html>
