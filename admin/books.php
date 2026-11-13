<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/config.php';
use App\Core\JsonDatabase; use App\Services\AuthService;
AuthService::requireRole('admin'); $db = new JsonDatabase(STORAGE_PATH); $error = null; $message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $action = (string) ($_POST['action'] ?? '');
        if ($action === 'delete') { $db->update('books', (string) $_POST['id'], static fn (array $book): ?array => null); $message = 'Buku dihapus.'; }
        else {
            $titleValue = trim((string) $_POST['title']); $author = trim((string) $_POST['author']); $category = trim((string) $_POST['category']); $stock = max(0, (int) $_POST['stock']);
            if ($titleValue === '' || $author === '' || $category === '') throw new RuntimeException('Semua data buku wajib diisi.');
            if ($action === 'update') {
                $db->update('books', (string) $_POST['id'], static function (array $book) use ($titleValue, $author, $category, $stock): array {
                    $book['title'] = $titleValue; $book['author'] = $author; $book['category'] = $category; $book['stock'] = $stock; return $book;
                });
                $message = 'Buku berhasil diperbarui.';
            } else {
                $db->insert('books', ['id' => 'bk-' . bin2hex(random_bytes(4)), 'title' => $titleValue, 'author' => $author, 'category' => $category, 'stock' => $stock, 'description' => trim((string) $_POST['description'])]); $message = 'Buku berhasil ditambahkan.';
            }
        }
    } catch (Throwable $exception) { $error = $exception->getMessage(); }
}
$books = $db->all('books'); $title = 'Kelola Buku'; $assetPrefix = '../'; require dirname(__DIR__) . '/partials/header.php';
?>
<div class="layout"><aside class="sidebar"><h2>Admin Panel</h2><nav><a href="dashboard.php">Dashboard</a><a class="active" href="books.php">Kelola Buku</a><a href="members.php">Kelola Member</a><a href="transactions.php">Transaksi</a></nav></aside><main class="main"><div class="main-header"><h1>Kelola E-Book</h1></div><?php if ($message): ?><div class="notice"><?= e($message) ?></div><?php endif; ?><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><section class="card form-card"><h2>Tambah buku</h2><form method="post"><input type="hidden" name="action" value="create"><div class="form-group"><label>Judul<input class="input" name="title" required></label></div><div class="form-group"><label>Penulis<input class="input" name="author" required></label></div><div class="form-group"><label>Kategori<input class="input" name="category" required></label></div><div class="form-group"><label>Stok<input class="input" name="stock" type="number" min="0" value="1" required></label></div><div class="form-group"><label>Deskripsi<textarea class="input" name="description" rows="3"></textarea></label></div><button class="btn btn-primary">Simpan buku</button></form></section><section class="section"><div class="table-wrap"><table class="table"><thead><tr><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr></thead><tbody><?php foreach ($books as $book): ?><tr><form method="post"><td><input class="input" name="title" value="<?= e((string) $book['title']) ?>" required></td><td><input class="input" name="author" value="<?= e((string) $book['author']) ?>" required></td><td><input class="input" name="category" value="<?= e((string) $book['category']) ?>" required></td><td><input class="input" name="stock" type="number" min="0" value="<?= e((string) $book['stock']) ?>" required></td><td><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= e((string) $book['id']) ?>"><button class="btn btn-light" type="submit">Simpan</button></form><form method="post"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e((string) $book['id']) ?>"><button class="btn btn-danger" data-confirm="Hapus buku ini?">Hapus</button></form></td></tr><?php endforeach; ?></tbody></table></div></section></main></div>
<?php $assetPrefix = '../'; require dirname(__DIR__) . '/partials/footer.php'; ?>
