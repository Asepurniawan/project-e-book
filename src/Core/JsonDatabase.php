<?php
declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class JsonDatabase
{
    public function __construct(private readonly string $directory) {}

    /** @return array<int, array<string, mixed>> */
    public function all(string $table): array
    {
        $path = $this->path($table);
        if (!is_file($path)) {
            return [];
        }
        $data = json_decode((string) file_get_contents($path), true);
        if (!is_array($data)) {
            throw new RuntimeException("Data {$table} tidak valid.");
        }
        return array_values(array_filter($data, 'is_array'));
    }

    /** @param array<string, mixed> $record */
    public function insert(string $table, array $record): void
    {
        $records = $this->all($table);
        $records[] = $record;
        $this->write($table, $records);
    }

    /** @param callable(array<string, mixed>): array<string, mixed>|null $mutator */
    public function update(string $table, string $id, callable $mutator): bool
    {
        $records = $this->all($table);
        $changed = false;
        foreach ($records as $index => $record) {
            if ((string) ($record['id'] ?? '') === $id) {
                $updated = $mutator($record);
                if ($updated === null) {
                    array_splice($records, $index, 1);
                } else {
                    $records[$index] = $updated;
                }
                $changed = true;
                break;
            }
        }
        if ($changed) {
            $this->write($table, $records);
        }
        return $changed;
    }

    /** @param array<int, array<string, mixed>> $records */
    public function replace(string $table, array $records): void
    {
        $this->write($table, $records);
    }

    private function path(string $table): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . $table . '.json';
    }

    /** @param array<int, array<string, mixed>> $records */
    private function write(string $table, array $records): void
    {
        if (!is_dir($this->directory) && !mkdir($this->directory, 0775, true) && !is_dir($this->directory)) {
            throw new RuntimeException('Folder penyimpanan tidak dapat dibuat.');
        }
        $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        if (file_put_contents($this->path($table), $json . PHP_EOL, LOCK_EX) === false) {
            throw new RuntimeException("Data {$table} tidak dapat disimpan.");
        }
    }
}
