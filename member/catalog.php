<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase;
use App\Services\AuthService;
use App\Services\LibraryService;
$user = AuthService::requireRole('member'); $service = new LibraryService(new JsonDatabase(STORAGE_PATH)); $message = null; $error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') { try { $service->borrow($user->getId(), (string) ($_POST['book_id'] ?? '')); $message = 'Buku berhasil dipinjam.'; } catch (Throwable $exception) { $error = $exception->getMessage(); } }
$books = $service->books(); $title = 'Katalog Member'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Member Area</h2><nav><a href="dashboard.php">Dashboard</a><a class="active" href="catalog.php">Katalog</a><a href="my-books.php">Buku Saya</a><a href="history.php">Riwayat</a></nav></aside><main class="main"><div class="main-header"><h1>Katalog E-Book</h1><input class="input" data-filter placeholder="Cari judul atau penulis" aria-label="Cari katalog"></div><?php if ($message): ?><div class="notice"><?= e($message) ?></div><?php endif; ?><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><div class="grid"><?php foreach ($books as $book): ?><article class="card" data-filter-item><div class="book-cover"><span><?= e($book->getCategory()) ?></span><strong><?= e($book->getTitle()) ?></strong><small><?= e($book->getAuthor()) ?></small></div><h3><?= e($book->getTitle()) ?></h3><p class="book-meta"><?= e($book->getAuthor()) ?> · Stok <?= $book->getStock() ?></p><form method="post"><input type="hidden" name="book_id" value="<?= e($book->getId()) ?>"><button class="btn btn-primary" type="submit" <?= $book->getStock() < 1 ? 'disabled' : '' ?>><?= $book->getStock() < 1 ? 'Stok habis' : 'Pinjam' ?></button></form></article><?php endforeach; ?></div></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
