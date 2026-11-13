<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
use App\Core\JsonDatabase;
use App\Services\AuthService;
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try { $user = (new AuthService(new JsonDatabase(STORAGE_PATH)))->login((string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? '')); redirect($user->getRole() === 'admin' ? 'admin/dashboard.php' : 'member/dashboard.php'); } catch (Throwable $exception) { $error = $exception->getMessage(); }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - E-Library UMM</title><link rel="stylesheet" href="assets/css/style.css"></head><body><main class="auth-page"><section class="auth-card"><a class="brand" href="index.php"><span>◈</span> E-LIBRARY UMM</a><h1>Selamat datang kembali</h1><p class="muted">Masuk untuk mengakses perpustakaan digital.</p><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="form-group"><label for="email">Email</label><input class="input" id="email" name="email" type="email" required></div><div class="form-group"><label for="password">Password</label><input class="input" id="password" name="password" type="password" required></div><button class="btn btn-primary" type="submit">Login</button></form><p class="muted">Belum punya akun? <a href="register.php">Daftar sekarang</a></p><p class="muted">Demo admin: admin@umm.ac.id / admin123</p></section></main></body></html>
