<?php
use App\Services\AuthService;
$currentUser = AuthService::current();
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($title ?? 'E-Library') ?></title><link rel="stylesheet" href="<?= e($assetPrefix ?? '') ?>assets/css/style.css"></head><body>
<header class="topbar"><div class="container topbar-inner"><a class="brand" href="<?= e($assetPrefix ?? '') ?>index.php"><span>◈</span> E-LIBRARY</a><nav class="top-nav"><a href="<?= e($assetPrefix ?? '') ?>index.php#katalog">Katalog</a><a href="<?= e($assetPrefix ?? '') ?>index.php#tentang">Tentang</a></nav><div class="top-actions"><?php if ($currentUser): ?><span class="user-chip hide-mobile">● <?= e($currentUser->getName()) ?></span><a href="<?= e($assetPrefix ?? '') ?>logout.php">Logout</a><?php else: ?><a href="<?= e($assetPrefix ?? '') ?>login.php">Login</a><a class="btn btn-light" href="<?= e($assetPrefix ?? '') ?>register.php">Daftar</a><?php endif; ?></div></div></header>
