<?php
declare(strict_types=1);
require_once __DIR__ . '/config/config.php';
use App\Services\AuthService;
AuthService::logout();
redirect('index.php');
