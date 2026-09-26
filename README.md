# Website Pengaduan Masyarakat BPBD

Website pengaduan masyarakat untuk Badan Penanggulangan Bencana Daerah (BPBD) Kota Tangerang Selatan. Aplikasi ini memungkinkan masyarakat mengirim laporan bencana atau masalah lingkungan, melihat status laporan, serta admin mengelola dan menanggapi pengaduan.

## Fitur Utama

- Pengisian laporan pengaduan oleh masyarakat
- Upload foto kejadian
- Pemilihan lokasi melalui peta (Leaflet)
- Status laporan: Menunggu, Ditanggapi, dan lainnya
- Halaman melihat status pengaduan
- Dashboard admin untuk mengelola laporan
- Export data laporan ke PDF/Excel/Print
- Login pengguna dan login admin
- Validasi input, CSRF, rate limiting, dan captcha pada login

## Teknologi yang Digunakan

- PHP 7+
- MySQL / MariaDB
- Bootstrap 3/4
- jQuery
- Leaflet.js
- DataTables
- PHPMailer

## Struktur Project

```text
WEBSITE_PM_BPBD/
├── admin/
│   ├── auth.php
│   ├── database.php
│   ├── export.php
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── tables.php
│   ├── css/
│   ├── images/
│   ├── js/
│   └── vendor/
├── css/
├── database/
│   └── BPBD.sql
├── images/
├── js/
├── private/
│   ├── database.php
│   └── validasi.php
├── uploads/
├── index.php
├── login.php
├── register.php
├── logout.php
├── lapor.php
├── lihat.php
├── cara.html
├── kontak.html
├── profildinas.html
├── error.html
├── README.md
└── Mail/
```

## Persyaratan

Sebelum menjalankan aplikasi, pastikan Anda sudah mempunyai:

- XAMPP / WAMP / Laragon
- PHP terinstal
- MySQL/MariaDB aktif
- Browser modern

## Cara Menjalankan

1. Clone atau download project ini ke folder web server, misalnya:

```bash
C:/xampp/htdocs/WEBSITE_PM_BPBD
```

2. Buat database MySQL baru dengan nama `bpbd`.

3. Import file SQL berikut:

```text
database/BPBD.sql
```

4. Pastikan konfigurasi database sudah sesuai pada file:

- `private/database.php`
- `admin/database.php`

Contoh konfigurasi default:

```php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "bpbd";
```

5. Jalankan project di browser:

```text
http://localhost/WEBSITE_PM_BPBD/
```

## Login Aplikasi

### User / Masyarakat

- Halaman utama: `login.php`
- Bisa mendaftar melalui `register.php`

### Admin

- URL admin: `http://localhost/WEBSITE_PM_BPBD/admin/login.php`
- Username default yang tersedia pada SQL:

```text
admin
```

Password default untuk akun admin biasanya di-set dari file SQL. Jika Anda meng-import database yang tersedia, pastikan password dan akun admin sesuai dengan data di tabel `admin`.

## Alur Penggunaan

### Pengguna

1. Daftar akun atau login.
2. Pilih menu `Lapor`.
3. Isi form pengaduan dengan data lengkap.
4. Pilih lokasi kejadian di peta.
5. Unggah foto bukti.
6. Kirim laporan.
7. Cek status laporan melalui menu `Lihat Pengaduan`.

### Admin

1. Login ke panel admin.
2. Lihat daftar laporan masuk.
3. Tanggapi laporan.
4. Ubah status laporan.
5. Export data laporan jika diperlukan.

## Catatan Penting

- Pastikan folder `uploads/` memiliki izin tulis agar foto bisa tersimpan.
- Jika ada masalah koneksi database, cek konfigurasi username, password, dan nama database.
- Project ini menggunakan file statis seperti `cara.html`, `kontak.html`, dan `profildinas.html` untuk halaman informasi publik.

## Kontribusi

Proyek ini bersifat open untuk pengembangan lebih lanjut, seperti:

- perbaikan UI/UX
- validasi laporan yang lebih ketat
- integrasi API cuaca atau maps
- notifikasi realtime
- sistem role admin yang lebih kompleks

## Lisensi

Project ini dibuat untuk kebutuhan pengelolaan laporan BPBD dan dapat dikembangkan sesuai kebutuhan instansi atau tim pengembang.

## Penutup

Aplikasi ini dirancang untuk mempermudah masyarakat dalam melaporkan kejadian bencana atau masalah darurat secara cepat, tertib, dan terdokumentasi dengan baik.
