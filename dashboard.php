<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
use App\Services\AuthService;
$user = AuthService::current();
if (!$user) redirect('login.php');
redirect($user->getRole() === 'admin' ? 'admin/dashboard.php' : 'member/dashboard.php');
