# Product Requirements Document (PRD): Simple Pro Voting System

## 1. Project Information
* **Project Name:** Simple Pro Voting System
* **Tech Stack:** Laravel 11, Filament PHP v3 (TALL Stack)
* **Database:** MySQL / PostgreSQL
* **Primary Goal:** Sistem voting terkontrol (Admin-centric) dengan dukungan grup dan publik.

---

## 2. Core Business Logic
1.  **Strict Enrollment:** Tidak ada registrasi mandiri. User hanya bisa ditambahkan oleh Admin.
2.  **Authentication:** Login menggunakan `username` dan `password`.
3.  **Plain Access Code:** Kolom `plain_code` digunakan untuk menyimpan kode akses unik/password dalam bentuk teks biasa (untuk mempermudah distribusi akun oleh admin).
4.  **Flexible Scope:** * **Public Voting:** Jika `group_id` kosong (null), semua user terdaftar bisa ikut.
    * **Group Voting:** Jika `group_id` diatur, hanya anggota grup tersebut yang bisa berpartisipasi.
5.  **One-Time Choice:** User hanya bisa memilih 1 kandidat per event voting. Pilihan tidak bisa diubah (Final).
6.  **Control Mechanism:** * Voting aktif jika berada di antara `start_time` dan `end_time`.
    * Admin memiliki master switch `is_active` untuk mematikan voting kapan saja.
7.  **Privacy:** Hasil voting hanya tampil jika Admin mengaktifkan flag `show_results`.

---

## 3. Security & Role Management
1.  **Role Identification:** Menggunakan kolom boolean `is_admin` pada tabel `users`.
2.  **Access Control:** * **Admin Panel:** Hanya user dengan `is_admin = true` yang dapat mengakses `/admin` (Filament Panel).
    * **Voter Interface:** User dengan `is_admin = false` hanya dapat mengakses halaman voting frontend.
3.  **Filament Guard:** Model `User` wajib mengimplementasikan interface `Filament\Models\Contracts\FilamentUser` dan method `canAccessPanel()` untuk memblokir akses Voter ke dashboard.

---

## 4. Database Schema (ERD)

### Entities & Attributes
* **users:** * `id`
    * `name`
    * `username` (unique)
    * `password`
    * `plain_code` (varchar 20, nullable) <--- Kolom kode akses/password teks biasa
    * `is_admin` (bool, default: false)
* **groups:** `id`, `name`, `description`.
* **group_user (Pivot):** `user_id`, `group_id`.
* **voting_events:** `id`, `group_id` (nullable), `title`, `description`, `thumbnail`, `start_time`, `end_time`, `is_active` (bool, default: true), `show_results` (bool, default: false).
* **options (Candidates):** `id`, `voting_event_id`, `candidate_name`, `photo`, `description`.
* **votes:** `id`, `user_id`, `voting_event_id`, `option_id`, `created_at`.

### Relationships
* `User` belongsToMany `Group` (via `group_user`).
* `Group` hasMany `VotingEvent`.
* `VotingEvent` hasMany `Option`.
* `VotingEvent` hasMany `Vote`.
* `User` hasMany `Vote` (Constraint: unique `user_id` + `voting_event_id`).

---

## 5. Filament v3 Technical Requirements
*PENTING: Gunakan standar Filament v3 untuk menghindari Namespace Error.*

1.  **Namespaces:** * Gunakan `Filament\Forms\Form` (Bukan `Filament\Resources\Form`).
    * Gunakan `Filament\Tables\Table` (Bukan `Filament\Resources\Table`).
2.  **Form Components:**
    * `TextInput::make('plain_code')->maxLength(20)` di UserResource.
    * `DateTimePicker` untuk `start_time` dan `end_time`.
    * `FileUpload` untuk `thumbnail` dan `photo`.
    * `Toggle` untuk `is_admin`, `is_active`, dan `show_results`.
3.  **Table Components:**
    * `TextColumn::make('plain_code')` agar admin bisa melihat kode akses langsung di tabel.
    * `ImageColumn` untuk foto kandidat.
    * `BadgeColumn` untuk status admin.
4.  **Database Validation:**
    * Tabel `votes` wajib memiliki unique index pada kombinasi `[user_id, voting_event_id]`.

---

## 6. Implementation Steps
1.  Generate Migration sesuai skema di atas.
2.  Update Model `User` dengan interface `FilamentUser`.
3.  Install Filament v3.
4.  Generate Resources via Filament CLI.
5.  Buat Controller untuk Frontend khusus Voter.