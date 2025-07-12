<!-- <?php
// Get all transactions
$query = "SELECT * FROM (
    SELECT id, 'Income' AS type, source AS category, amount, created_at FROM income
    UNION ALL
    SELECT id, 'Expense' AS type, category, amount, created_at FROM expenses
) AS transactions ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}
?>

<h1 class="text-2xl font-bold text-center mb-6">All Transactions 🧾</h1>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-200 text-gray-800 text-center">
            <tr>
                <th class="px-6 py-3">S.N</th>
                <th class="px-6 py-3">Type</th>
                <th class="px-6 py-3">Category/Source</th>
                <th class="px-6 py-3">Amount (Rs)</th>
                <th class="px-6 py-3">Date</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php if (count($transactions) > 0): ?>
                <?php foreach ($transactions as $i => $item): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-3"><?= $i + 1 ?></td>
                        <td class="px-6 py-3 font-semibold"><?= htmlspecialchars($item['type']) ?></td>
                        <td class="px-6 py-3"><?= htmlspecialchars($item['category']) ?></td>
                        <td class="px-6 py-3">Rs. <?= number_format($item['amount'], 2) ?></td>
                        <td class="px-6 py-3"><?= date('Y-m-d', strtotime($item['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No Transactions Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> -->
