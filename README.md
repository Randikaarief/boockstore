# Website Penjualan Buku

## Deskripsi Singkat Proyek

Website Penjualan Buku merupakan aplikasi web yang digunakan untuk mengelola dan melakukan transaksi penjualan buku secara online. Aplikasi ini menyediakan fitur pengelolaan data buku, pengguna, serta proses pemesanan yang dapat diakses melalui browser.

Proyek ini dibuat sebagai bagian dari tugas perkuliahan dengan tujuan menerapkan konsep web dinamis menggunakan backend dan database.

## Fitur-Fitur Utama

* Login dan Logout pengguna
* Manajemen data buku (tambah, ubah, hapus, dan lihat buku)
* Manajemen pengguna (admin dan user)
* Proses pemesanan buku
* Keranjang belanja
* Riwayat transaksi
* Tampilan antarmuka berbasis web yang sederhana dan mudah digunakan

## Teknologi yang Digunakan

* Bahasa Pemrograman: PHP
* Database: MySQL
* Web Server: Apache (XAMPP)
* Frontend: HTML, CSS, JavaScript (Bootstrap)

## Cara Menjalankan Website (Setup)

1. Pastikan sudah menginstal **XAMPP** atau web server sejenis.
2. Jalankan **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Salin folder project ke dalam direktori:

   ```
   C:/xampp/htdocs/
   ```
4. Buat database baru di phpMyAdmin dengan nama:

   ```
   db_jualbuku
   ```
5. Import file database (`.sql`) yang tersedia di folder project ke database tersebut.
6. Atur koneksi database pada file konfigurasi (contoh: `config/koneksi.php`) sesuai dengan pengaturan MySQL:

   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "db_jualbuku";
   ```
7. Buka browser dan akses aplikasi melalui URL:

   ```
   http://localhost/penjualanbuku/
   ```
8. Website siap dijalankan.

## Akun Default (Jika Ada)

* **Admin**

  * Username: admin
  * Password: admin

## Screenshot Tampilan Website

Berikut adalah beberapa tampilan dari website:

* Halaman Login
* Halaman Dashboard
* Halaman Daftar Buku
* Halaman Keranjang dan Transaksi

(Screenshot diletakkan pada folder `screenshot/` di dalam repository)
