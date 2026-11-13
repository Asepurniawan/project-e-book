<?php
declare(strict_types=1);

namespace App\Models;

final class Book
{
    public function __construct(
        private string $id,
        private string $title,
        private string $author,
        private string $category,
        private int $stock = 1,
        private string $description = '',
    ) {}

    public function getId(): string { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getCategory(): string { return $this->category; }
    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): void { $this->stock = max(0, $stock); }
    public function getDescription(): string { return $this->description; }

    /** @return array<string, int|string> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'title' => $this->title, 'author' => $this->author, 'category' => $this->category, 'stock' => $this->stock, 'description' => $this->description];
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self((string) ($data['id'] ?? ''), (string) ($data['title'] ?? ''), (string) ($data['author'] ?? ''), (string) ($data['category'] ?? 'Umum'), (int) ($data['stock'] ?? 1), (string) ($data['description'] ?? ''));
    }
}
