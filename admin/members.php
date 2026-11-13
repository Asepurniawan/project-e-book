<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase; use App\Services\AuthService;
AuthService::requireRole('admin'); $db = new JsonDatabase(STORAGE_PATH); $members = array_filter($db->all('users'), static fn (array $user): bool => ($user['role'] ?? '') === 'member'); $title = 'Kelola Member'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Admin Panel</h2><nav><a href="dashboard.php">Dashboard</a><a href="books.php">Kelola Buku</a><a class="active" href="members.php">Kelola Member</a><a href="transactions.php">Transaksi</a></nav></aside><main class="main"><div class="main-header"><h1>Data Member</h1></div><div class="table-wrap"><table class="table"><thead><tr><th>Nama</th><th>Email</th><th>ID</th><th>Role</th></tr></thead><tbody><?php foreach ($members as $member): ?><tr><td><?= e((string) $member['name']) ?></td><td><?= e((string) $member['email']) ?></td><td><?= e((string) $member['id']) ?></td><td><span class="badge success">Member</span></td></tr><?php endforeach; ?><?php if (!$members): ?><tr><td colspan="4" class="empty">Belum ada member.</td></tr><?php endif; ?></tbody></table></div></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
