<?php
declare(strict_types=1);

namespace EBook;

interface Transaction
{
    public function summary(): string;
}

final class Loan implements Transaction
{
    public function __construct(
        private readonly string $title,
        private readonly int $days = 14
    ) {}

    public function summary(): string
    {
        return "Buku \"{$this->title}\" berhasil dipinjam selama {$this->days} hari.";
    }
}
