# E-Library UMM

Aplikasi UTS Pemrograman Web untuk katalog e-book, autentikasi pengguna, dashboard admin/member, dan simulasi peminjaman serta pengembalian.

## Fitur

- Registrasi, login, logout, session PHP, dan role `admin`/`member`.
- Password disimpan menggunakan `password_hash()` dan diverifikasi dengan `password_verify()`.
- CRUD buku melalui dashboard admin.
- Statistik admin, data member, dan data transaksi.
- Katalog, pencarian, validasi stok, peminjaman, pengembalian, dan riwayat member.
- JSON database dengan `LOCK_EX` saat penulisan.
- OOP nyata: class, object, encapsulation, inheritance, polymorphism, interface, dan namespace `App\Models`, `App\Services`, serta `App\Core`.

## Menjalankan di XAMPP

1. Salin folder proyek ke `C:\xampp\htdocs\e-library`.
2. Pastikan PHP 8.x aktif.
3. Jalankan Apache dari XAMPP.
4. Buka `http://localhost/e-library/`.

Alternatif tanpa XAMPP:

```bash
php -S localhost:8000
```

## Akun demo

- Admin: `admin@umm.ac.id`
- Password: `admin123`

Member dapat dibuat melalui halaman registrasi.

## Struktur utama

```text
config/config.php       bootstrap, session, autoload, helper
src/Core                JsonDatabase dengan file locking
src/Models              User, Admin, Member, Book, Transaction
src/Services             AuthService dan LibraryService
storage                  users.json, books.json, transactions.json
admin                    dashboard dan pengelolaan data
member                   katalog, dashboard, buku saya, riwayat
assets                   CSS responsif dan JavaScript interaksi
```
