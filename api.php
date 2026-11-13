<?php
declare(strict_types=1);

require_once __DIR__ . '/src/User.php';
require_once __DIR__ . '/src/Transaction.php';

use EBook\Member;
use EBook\Loan;

header('Content-Type: application/json; charset=utf-8');

try {
    $action = $_POST['action'] ?? '';
    if ($action === 'register') {
        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        if (mb_strlen($name) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(422);
            throw new InvalidArgumentException('Nama minimal 3 karakter dan email harus valid.');
        }
        $member = new Member($name, $email);
        echo json_encode(['success' => true, 'message' => "Selamat datang, {$member->getName()}!"]);
        exit;
    }

    if ($action === 'borrow') {
        $title = trim((string) ($_POST['title'] ?? ''));
        if ($title === '') {
            http_response_code(422);
            throw new InvalidArgumentException('Judul buku tidak boleh kosong.');
        }
        $loan = new Loan($title);
        echo json_encode(['success' => true, 'message' => $loan->summary()]);
        exit;
    }

    http_response_code(400);
    throw new InvalidArgumentException('Aksi tidak dikenali.');
} catch (Throwable $error) {
    echo json_encode(['success' => false, 'message' => $error->getMessage()]);
}
