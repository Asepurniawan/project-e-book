<?php
declare(strict_types=1);

namespace App\Models;

abstract class User
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $email,
        protected string $passwordHash,
    ) {}

    abstract public function getRole(): string;
    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPasswordHash(): string { return $this->passwordHash; }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'email' => $this->email, 'password' => $this->passwordHash, 'role' => $this->getRole()];
    }
}
