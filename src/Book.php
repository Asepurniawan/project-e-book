<?php
declare(strict_types=1);

namespace EBook;

final class Book extends Media
{
    public function __construct(
        string $id,
        string $title,
        string $author,
        string $category,
        public readonly int $pages,
        public readonly string $coverClass
    ) {
        parent::__construct($id, $title, $author, $category);
    }

    public function getTypeLabel(): string { return 'E-Book'; }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) $data['id'],
            (string) $data['title'],
            (string) $data['author'],
            (string) $data['category'],
            (int) $data['pages'],
            (string) $data['coverClass']
        );
    }
}
