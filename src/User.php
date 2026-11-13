<?php
declare(strict_types=1);

namespace EBook;

class User
{
    public function __construct(
        protected readonly string $name,
        protected readonly string $email
    ) {}

    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
}

final class Member extends User
{
    public function getMembershipLabel(): string { return 'Member Litera'; }
}
