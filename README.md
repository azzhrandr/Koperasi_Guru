# Sistem Informasi Koperasi Simpan Pinjam Guru

## Deskripsi

Sistem Informasi Koperasi Simpan Pinjam Guru merupakan aplikasi berbasis website yang dikembangkan menggunakan framework Laravel. Aplikasi ini bertujuan untuk membantu proses administrasi koperasi secara digital, mulai dari pengelolaan data anggota, pencatatan simpanan, pengelolaan pinjaman, pembayaran angsuran, hingga pembuatan laporan.

Project ini dibuat sebagai tugas akhir (UAS) Mata Kuliah **Pemrograman Web**.

---

## Teknologi yang Digunakan

- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap 5
- HTML5
- CSS3
- JavaScript

---

## Fitur Aplikasi

### Admin
- Login
- Dashboard Admin
- Kelola Data Anggota
- Kelola Simpanan
- Detail Mutasi Simpanan
- Kelola Pinjaman
- Persetujuan / Penolakan Pinjaman
- Pembayaran Angsuran
- Laporan
- Profil Admin

### Anggota
- Login
- Dashboard Anggota
- Melihat Simpanan
- Pengajuan Pinjaman
- Melihat Status Pinjaman
- Profil Anggota

---

## Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/azzhrandr/Koperasi_Guru.git
```

Masuk ke folder project.

```bash
cd Koperasi_Guru
```

---

### 2. Install Dependency

```bash
composer install
```

---

### 3. Install Package Frontend

```bash
npm install
```

---

### 4. Copy File Environment

Copy file:

```
.env.example
```

menjadi

```
.env
```

---

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

### 6. Konfigurasi Database

Buka file `.env` kemudian sesuaikan konfigurasi database.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=koperasi_simpanpinjam
DB_USERNAME=root
DB_PASSWORD=
```

---

### 7. Import Database

Import file database:

```
koperasi_simpanpinjam.sql
```

melalui phpMyAdmin.

---

### 8. Jalankan Server

```bash
php artisan serve
```

Buka browser:

```
http://127.0.0.1:8000
```

---

## Struktur Hak Akses

### Admin

Admin memiliki hak akses untuk:

- Mengelola Data Anggota
- Mengelola Simpanan
- Mengelola Pinjaman
- Melakukan Persetujuan Pinjaman
- Mencatat Pembayaran Angsuran
- Melihat Laporan
- Mengubah Profil

---

### Anggota

Anggota memiliki hak akses untuk:

- Melihat Dashboard
- Melihat Simpanan
- Mengajukan Pinjaman
- Melihat Status Pinjaman
- Mengubah Profil

---

## Akun Demo

### Admin

Email

```
admin@koperasi.id
```

Password

```
admin12345
```

---

### Anggota

Email

```
cyntia@gmail.id
```

Password

```
cyntia12345
```

---

## Developer

**Nama Project**

Sistem Informasi Koperasi Simpan Pinjam Guru

**Framework**

Laravel 12

**Database**

MySQL

**Mata Kuliah**

Pemrograman Web

---

## Lisensi

Project ini dibuat hanya untuk keperluan pembelajaran dan tugas akademik.
