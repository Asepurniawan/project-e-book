<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
use App\Core\JsonDatabase;
use App\Services\LibraryService;
$service = new LibraryService(new JsonDatabase(STORAGE_PATH));
$books = $service->books();
$title = 'Katalog E-Book';
require __DIR__ . '/partials/header.php';
?>
<section class="hero"><div class="hero-glow hero-glow-one"></div><div class="hero-glow hero-glow-two"></div><div class="container hero-layout"><div class="hero-copy"><p class="eyebrow">PERPUSTAKAAN DIGITAL</p><h1>Pengetahuan tanpa <span>batas.</span></h1><p>Temukan koleksi e-book pilihan untuk mendukung pembelajaran, riset, dan pengembangan diri.</p><div class="hero-actions"><a class="btn btn-primary" href="#katalog">Jelajahi katalog <span>→</span></a><a class="text-link" href="about.html">Kenali E-Library <span>↗</span></a></div><div class="hero-trust"><div><strong><?= count($books) ?>+</strong><span>Judul pilihan</span></div><div><strong>24/7</strong><span>Akses kapan saja</span></div><div><strong>100%</strong><span>Digital & praktis</span></div></div></div><div class="hero-art" aria-label="Ilustrasi koleksi buku"><div class="art-circle"></div><div class="art-book art-book-back"><small>READ</small><strong>MORE</strong></div><div class="art-book art-book-front"><small>E-LIBRARY</small><strong>Ideas<br>change<br>everything.</strong><i>✦</i></div><div class="art-label">KOLEKSI<br><b>TERBAIK</b></div></div></div></section>
<section class="feature-strip" aria-label="Keunggulan E-Library">
  <div class="container feature-grid">
    <article class="feature-item">
      <span class="feature-icon">⌕</span>
      <div><h3>Temukan lebih cepat</h3><p>Cari judul, penulis, dan kategori favoritmu dalam satu tempat.</p></div>
    </article>
    <article class="feature-item">
      <span class="feature-icon">↗</span>
      <div><h3>Akses kapan saja</h3><p>Nikmati koleksi digital dengan pengalaman membaca yang praktis.</p></div>
    </article>
    <article class="feature-item">
      <span class="feature-icon">✓</span>
      <div><h3>Peminjaman mudah</h3><p>Pinjam buku dengan cepat dan pantau riwayat peminjamanmu.</p></div>
    </article>
  </div>
</section>
<main class="section container" id="katalog">
  <div class="section-title"><div><p class="eyebrow">KOLEKSI DIGITAL</p><h2>Temukan bacaanmu.</h2><p class="section-subtitle">Bacaan yang tepat bisa mengubah cara pandangmu.</p></div><div class="controls"><div class="search-box"><span>⌕</span><input class="input" data-filter placeholder="Cari judul, penulis, atau kategori" aria-label="Cari buku"></div></div></div>
  <div class="grid"><?php foreach ($books as $book): ?><article class="card book-card" data-filter-item><div class="book-cover"><span><?= e($book->getCategory()) ?></span><strong><?= e($book->getTitle()) ?></strong><small><?= e($book->getAuthor()) ?></small></div><h3><?= e($book->getTitle()) ?></h3><p class="book-meta"><?= e($book->getAuthor()) ?> · Stok <?= $book->getStock() ?></p><?php if (App\Services\AuthService::current()): ?><form method="post" action="member/catalog.php"><input type="hidden" name="book_id" value="<?= e($book->getId()) ?>"><button class="btn btn-primary" type="submit">Pinjam buku</button></form><?php else: ?><a class="btn btn-light" href="login.php">Login untuk meminjam</a><?php endif; ?></article><?php endforeach; ?></div>
  <div class="catalog-footer"><span>Menampilkan <?= count($books) ?> koleksi pilihan</span><a class="text-link" href="register.php">Bergabung sebagai member →</a></div>
</main>
<section class="about-section" id="tentang"><div class="container about-grid"><div><p class="eyebrow">SATU RUANG, BANYAK KEMUNGKINAN</p><h2>Belajar lebih mudah dengan E-Library.</h2></div><p>Akses bacaan digital dengan pengalaman yang sederhana, cepat, dan nyaman. Simpan waktumu untuk hal-hal yang lebih penting: membaca, belajar, dan bertumbuh.</p></div></section>
<?php require __DIR__ . '/partials/footer.php'; ?>
