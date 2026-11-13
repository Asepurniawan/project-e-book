<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase;
use App\Services\AuthService;
use App\Services\LibraryService;
$user = AuthService::requireRole('member');
$db = new JsonDatabase(STORAGE_PATH);
$books = (new LibraryService($db))->books();
$transactions = array_values(array_filter($db->all('transactions'), static fn (array $row): bool => ($row['member_id'] ?? '') === $user->getId()));
$title = 'Dashboard Member'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Member Area</h2><nav><a class="active" href="dashboard.php">Dashboard</a><a href="catalog.php">Katalog</a><a href="my-books.php">Buku Saya</a><a href="history.php">Riwayat</a></nav></aside><main class="main"><div class="main-header"><h1>Dashboard Member</h1><a class="btn btn-primary" href="catalog.php">Cari buku</a></div><div class="stats"><div class="card"><span class="muted">Total koleksi</span><strong><?= count($books) ?></strong></div><div class="card"><span class="muted">Sedang dipinjam</span><strong><?= count(array_filter($transactions, static fn (array $t): bool => ($t['status'] ?? '') === 'Dipinjam')) ?></strong></div><div class="card"><span class="muted">Total riwayat</span><strong><?= count($transactions) ?></strong></div></div><section class="section"><div class="section-title"><h2>Koleksi pilihan</h2></div><div class="grid"><?php foreach (array_slice($books, 0, 4) as $book): ?><article class="card"><div class="book-cover"><strong><?= e($book->getTitle()) ?></strong><small><?= e($book->getAuthor()) ?></small></div><h3><?= e($book->getTitle()) ?></h3><a class="btn btn-light" href="catalog.php">Lihat katalog</a></article><?php endforeach; ?></div></section></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
