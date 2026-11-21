<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
use App\Core\JsonDatabase;
use App\Services\AuthService;
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try { (new AuthService(new JsonDatabase(STORAGE_PATH)))->register((string) ($_POST['name'] ?? ''), (string) ($_POST['email'] ?? ''), (string) ($_POST['password'] ?? '')); redirect('login.php'); } catch (Throwable $exception) { $error = $exception->getMessage(); }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Registrasi - E-Library</title><link rel="stylesheet" href="assets/css/style.css"></head><body><main class="auth-page"><section class="auth-card"><a class="brand" href="index.php"><span>◈</span> E-LIBRARY</a><h1>Buat akun member</h1><?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="form-group"><label for="name">Nama lengkap</label><input class="input" id="name" name="name" minlength="3" required></div><div class="form-group"><label for="email">Email</label><input class="input" id="email" name="email" type="email" required></div><div class="form-group"><label for="password">Password</label><input class="input" id="password" name="password" type="password" minlength="6" required></div><button class="btn btn-primary" type="submit">Daftar</button></form><p class="muted">Sudah punya akun? <a href="login.php">Login</a></p></section></main></body></html>
