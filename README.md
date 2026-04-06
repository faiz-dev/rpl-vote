# Simple Pro Voting System

Sistem voting terkontrol berbasis web dengan panel admin modern. Dibangun menggunakan Laravel 11 dan Filament PHP.

## Fitur Utama

- Panel admin berbasis Filament PHP untuk mengelola event voting, kandidat, user, dan grup
- Sistem voting terkontrol: user hanya bisa memilih satu kali per event (final, tidak bisa diubah)
- Dukungan voting publik (semua user) dan voting berbasis grup
- Kontrol penuh oleh admin: master switch aktif/nonaktif, tampil/sembunyikan hasil
- Autentikasi menggunakan `username` dan `password`
- Antarmuka voting terpisah untuk voter

---

## Requirements

Pastikan server atau mesin lokal Anda memenuhi spesifikasi berikut sebelum melakukan instalasi:

| Komponen | Versi Minimum | Download |
|---|---|---|
| PHP | 8.2 | (sudah termasuk dalam Laragon) |
| Composer | 2.x | https://getcomposer.org/download/ |
| Node.js | 18.x | https://nodejs.org/en/download |
| NPM | 9.x | (sudah termasuk bersama Node.js) |
| Database | MySQL 8.0+ / PostgreSQL 13+ | (sudah termasuk dalam Laragon) |

### PHP Extensions yang dibutuhkan

- `BCMath`
- `Ctype`
- `cURL`
- `DOM`
- `Fileinfo`
- `JSON`
- `Mbstring`
- `OpenSSL`
- `PCRE`
- `PDO`
- `Tokenizer`
- `XML`

---

## Instalasi

### 1. Clone Repository

```bash
git clone <url-repository> admin-vote
cd admin-vote
```

> **Pengguna Laragon:** Clone project ke dalam folder `www` yang ada di direktori instalasi Laragon, biasanya di `C:\laragon\www\`. Setelah di-clone, project akan otomatis dapat diakses melalui `http://admin-vote.test`.

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="Simple Pro Voting System"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_vote
DB_USERNAME=root
DB_PASSWORD=
```

> Untuk PostgreSQL, ubah `DB_CONNECTION=pgsql` dan sesuaikan port ke `5432`.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database baru di MySQL/PostgreSQL sesuai nama yang diset di `DB_DATABASE` pada file `.env`.

### 7. Jalankan Migrasi

```bash
php artisan migrate
```

### 8. Buat Storage Link

```bash
php artisan storage:link
```

### 9. Build Assets Frontend

Untuk development:

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 10. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

---

## Seeding Data Awal

Jalankan seeder untuk membuat akun admin, grup, voter sampel, dan event voting contoh:

```bash
php artisan db:seed
```

Seeder akan membuat data berikut secara otomatis:

| Akun | Username | Password | Role |
|---|---|---|---|
| Administrator | `admin` | `password` | Admin |
| Alice Voter | `alice` | `password` | Voter |
| Bob Voter | `bob` | `password` | Voter |
| Charlie Voter | `charlie` | `password` | Voter |

Setelah selesai, login ke panel admin di `http://localhost:8000/admin` menggunakan akun `admin` / `password`.

---

## Akses Aplikasi

| URL | Keterangan |
|---|---|
| `/admin` | Panel admin (khusus user dengan `is_admin = true`) |
| `/vote` | Halaman voting untuk voter |

---

## Tech Stack

- **Framework:** Laravel 11
- **Admin Panel:** Filament PHP v5
- **Frontend Build:** Vite
- **Database:** MySQL / PostgreSQL

## License

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
