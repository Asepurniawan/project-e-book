<?php
declare(strict_types=1);

namespace EBook\Repository;

use RuntimeException;

final class JsonRepository
{
    public function __construct(private readonly string $path) {}

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException('Data katalog tidak dapat dibaca.');
        }
        $data = json_decode((string) file_get_contents($this->path), true);
        if (!is_array($data)) {
            throw new RuntimeException('Format data katalog tidak valid.');
        }
        return $data;
    }
}
