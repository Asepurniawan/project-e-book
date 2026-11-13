<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\JsonDatabase;
use App\Models\Admin;
use App\Models\Member;
use App\Models\User;
use RuntimeException;

final class AuthService
{
    public function __construct(private readonly JsonDatabase $db) {}

    public function register(string $name, string $email, string $password): User
    {
        $name = trim($name);
        $email = strtolower(trim($email));
        if (mb_strlen($name) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            throw new RuntimeException('Nama minimal 3 karakter, email valid, dan password minimal 6 karakter.');
        }
        foreach ($this->db->all('users') as $user) {
            if (strtolower((string) ($user['email'] ?? '')) === $email) {
                throw new RuntimeException('Email sudah terdaftar.');
            }
        }
        $member = new Member('usr-' . bin2hex(random_bytes(5)), $name, $email, password_hash($password, PASSWORD_DEFAULT));
        $this->db->insert('users', $member->toArray());
        return $member;
    }

    public function login(string $email, string $password): User
    {
        $email = strtolower(trim($email));
        foreach ($this->db->all('users') as $data) {
            if (strtolower((string) ($data['email'] ?? '')) === $email && password_verify($password, (string) ($data['password'] ?? ''))) {
                $user = ($data['role'] ?? 'member') === 'admin'
                    ? new Admin((string) $data['id'], (string) $data['name'], (string) $data['email'], (string) $data['password'])
                    : new Member((string) $data['id'], (string) $data['name'], (string) $data['email'], (string) $data['password']);
                $_SESSION['user'] = $user->toArray();
                return $user;
            }
        }
        throw new RuntimeException('Email atau password salah.');
    }

    public static function current(): ?User
    {
        $data = $_SESSION['user'] ?? null;
        if (!is_array($data)) return null;
        return ($data['role'] ?? 'member') === 'admin'
            ? new Admin((string) $data['id'], (string) $data['name'], (string) $data['email'], (string) $data['password'])
            : new Member((string) $data['id'], (string) $data['name'], (string) $data['email'], (string) $data['password']);
    }

    public static function requireRole(string $role): User
    {
        $user = self::current();
        if (!$user || $user->getRole() !== $role) redirect('../login.php');
        return $user;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }
}
