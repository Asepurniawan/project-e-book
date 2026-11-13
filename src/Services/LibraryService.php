<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\JsonDatabase;
use App\Models\Book;
use App\Models\Transaction;
use RuntimeException;

final class LibraryService
{
    public function __construct(private readonly JsonDatabase $db) {}

    /** @return array<int, Book> */
    public function books(): array
    {
        return array_map(static fn (array $row): Book => Book::fromArray($row), $this->db->all('books'));
    }

    public function borrow(string $memberId, string $bookId): void
    {
        $books = $this->db->all('books');
        $bookFound = false;
        foreach ($books as $index => $book) {
            if ((string) $book['id'] === $bookId) {
                $bookFound = true;
                if ((int) ($book['stock'] ?? 0) < 1) throw new RuntimeException('Stok buku tidak tersedia.');
                $books[$index]['stock'] = (int) $book['stock'] - 1;
                break;
            }
        }
        if (!$bookFound) throw new RuntimeException('Buku tidak ditemukan.');
        $this->db->replace('books', $books);
        $this->db->insert('transactions', (new Transaction('trx-' . bin2hex(random_bytes(5)), $memberId, $bookId, date('Y-m-d'), date('Y-m-d', strtotime('+14 days'))))->toArray());
    }

    public function returnBook(string $memberId, string $transactionId): void
    {
        $transactions = $this->db->all('transactions');
        foreach ($transactions as $index => $row) {
            if ((string) $row['id'] === $transactionId && (string) $row['member_id'] === $memberId && ($row['status'] ?? '') === Transaction::BORROWED) {
                $transaction = Transaction::fromArray($row);
                $transaction->returnBook();
                $transactions[$index] = $transaction->toArray();
                $this->db->replace('transactions', $transactions);
                $this->db->update('books', (string) $row['book_id'], static function (array $book): array {
                    $book['stock'] = (int) ($book['stock'] ?? 0) + 1;
                    return $book;
                });
                return;
            }
        }
        throw new RuntimeException('Transaksi tidak dapat dikembalikan.');
    }
}
