<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase; use App\Services\AuthService; use App\Services\LibraryService;
AuthService::requireRole('member'); $id = (string) ($_GET['id'] ?? ''); $book = null; foreach ((new LibraryService(new JsonDatabase(STORAGE_PATH)))->books() as $candidate) if ($candidate->getId() === $id) $book = $candidate; if (!$book) redirect('catalog.php'); $title = 'Detail Buku'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Member Area</h2><nav><a href="dashboard.php">Dashboard</a><a href="catalog.php">Katalog</a><a href="my-books.php">Buku Saya</a><a href="history.php">Riwayat</a></nav></aside><main class="main"><div class="card form-card"><div class="book-cover"><span><?= e($book->getCategory()) ?></span><strong><?= e($book->getTitle()) ?></strong><small><?= e($book->getAuthor()) ?></small></div><h1><?= e($book->getTitle()) ?></h1><p class="muted">Penulis: <?= e($book->getAuthor()) ?> · Stok: <?= $book->getStock() ?></p><p><?= e($book->getDescription()) ?></p><a class="btn btn-primary" href="catalog.php">Kembali ke katalog</a></div></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
