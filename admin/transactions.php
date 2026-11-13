<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase; use App\Services\AuthService;
AuthService::requireRole('admin'); $db = new JsonDatabase(STORAGE_PATH); $transactions = $db->all('transactions'); $title = 'Kelola Transaksi'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Admin Panel</h2><nav><a href="dashboard.php">Dashboard</a><a href="books.php">Kelola Buku</a><a href="members.php">Kelola Member</a><a class="active" href="transactions.php">Transaksi</a></nav></aside><main class="main"><div class="main-header"><h1>Data Transaksi</h1></div><div class="table-wrap"><table class="table"><thead><tr><th>ID</th><th>Member</th><th>Buku</th><th>Pinjam</th><th>Jatuh tempo</th><th>Kembali</th><th>Status</th></tr></thead><tbody><?php foreach ($transactions as $transaction): ?><tr><td><?= e((string) $transaction['id']) ?></td><td><?= e((string) $transaction['member_id']) ?></td><td><?= e((string) $transaction['book_id']) ?></td><td><?= e((string) $transaction['borrowed_at']) ?></td><td><?= e((string) $transaction['due_at']) ?></td><td><?= e((string) ($transaction['returned_at'] ?? '-')) ?></td><td><span class="badge"><?= e((string) $transaction['status']) ?></span></td></tr><?php endforeach; ?><?php if (!$transactions): ?><tr><td colspan="7" class="empty">Belum ada transaksi.</td></tr><?php endif; ?></tbody></table></div></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
