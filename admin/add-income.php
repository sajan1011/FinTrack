

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Income</title>
    <link href="src/output.css" rel="stylesheet">

</head>
<body class="bg-blue-100">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">Add Income</h2>
        <form action="add-income-handle.php" method="POST" class="space-y-4">
            <input type="text" name="source" placeholder="Source" required class="w-full px-4 py-2 border rounded" />
            <input type="number" name="amount" placeholder="Amount (Rs)" required class="w-full px-4 py-2 border rounded" />
            <input type="date" name="date" required class="w-full px-4 py-2 border rounded" />
            <textarea name="note" placeholder="Note (optional)" class="w-full px-4 py-2 border rounded"></textarea>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Add Income</button>
        </form>
    </div>
</body>
</html>
