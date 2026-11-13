<?php
declare(strict_types=1);

namespace App\Models;

final class Transaction
{
    public const BORROWED = 'Dipinjam';
    public const RETURNED = 'Dikembalikan';
    public const OVERDUE = 'Terlambat';

    public function __construct(
        private string $id,
        private string $memberId,
        private string $bookId,
        private string $borrowedAt,
        private string $dueAt,
        private ?string $returnedAt = null,
        private string $status = self::BORROWED,
    ) {}

    public function getId(): string { return $this->id; }
    public function getMemberId(): string { return $this->memberId; }
    public function getBookId(): string { return $this->bookId; }
    public function getStatus(): string { return $this->status; }
    public function getDueAt(): string { return $this->dueAt; }
    public function getReturnedAt(): ?string { return $this->returnedAt; }

    public function returnBook(): void
    {
        $this->returnedAt = date('Y-m-d');
        $this->status = $this->returnedAt > $this->dueAt ? self::OVERDUE : self::RETURNED;
    }

    /** @return array<string, string|null> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'member_id' => $this->memberId, 'book_id' => $this->bookId, 'borrowed_at' => $this->borrowedAt, 'due_at' => $this->dueAt, 'returned_at' => $this->returnedAt, 'status' => $this->status];
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self((string) $data['id'], (string) $data['member_id'], (string) $data['book_id'], (string) $data['borrowed_at'], (string) $data['due_at'], isset($data['returned_at']) ? (string) $data['returned_at'] : null, (string) ($data['status'] ?? self::BORROWED));
    }
}
