# Sistem Informasi Manajemen Bengkel

Sistem Informasi Manajemen Bengkel adalah aplikasi web berbasis Laravel yang digunakan untuk membantu pengelolaan data bengkel, seperti data barang, kategori barang, pelanggan, purchase order, barang masuk, transaksi penjualan, stok barang, history stok, stock opname, cetak nota, serta laporan.

Project ini dibuat sebagai bagian dari tugas akhir/skripsi.

---

## Fitur Utama

* Login pengguna berdasarkan role
* Dashboard ringkasan data
* Manajemen data barang
* Manajemen kategori barang
* Manajemen pelanggan
* Purchase order barang
* Input mitra/supplier pada purchase order
* Pencatatan barang masuk berdasarkan purchase order
* Transaksi penjualan
* History stok barang
* Stock opname / koreksi stok barang
* Notifikasi stok menipis dan stok habis
* Cetak nota transaksi
* Export laporan PDF
* Export laporan Excel
* Manajemen akun pengguna

---

## Role Pengguna

### Admin

Admin memiliki akses utama untuk mengelola hampir seluruh fitur sistem, seperti:

* Dashboard
* Data barang
* Data kategori barang
* Data pelanggan
* Purchase order
* Barang masuk
* Transaksi penjualan
* History stok
* Stock opname
* Laporan
* Data pengguna / akun sistem

### Kasir

Kasir dapat menggunakan fitur yang berhubungan dengan proses penjualan, seperti:

* Melakukan transaksi penjualan
* Mencetak nota transaksi
* Mengelola data pelanggan sesuai hak akses
* Melihat data transaksi sesuai hak akses

### Gudang

Gudang dapat mengelola fitur yang berhubungan dengan stok dan persediaan barang, seperti:

* Data barang
* Data kategori barang
* Purchase order
* Barang masuk
* History stok
* Stock opname
* Notifikasi stok menipis atau stok habis

### Owner

Owner dapat melihat informasi laporan dan ringkasan sistem, seperti:

* Dashboard sesuai hak akses
* Laporan transaksi
* Laporan barang masuk
* Laporan history stok
* Export laporan PDF
* Export laporan Excel

Catatan: pembagian akses dapat disesuaikan kembali berdasarkan kebutuhan sistem dan aturan role yang diterapkan pada project.

---

## Teknologi yang Digunakan

* Laravel 12
* PHP
* MySQL / MariaDB
* Blade Template
* Bootstrap
* AdminLTE 3
* DomPDF untuk cetak laporan PDF dan nota
* FastExcel untuk export laporan Excel
* Git & GitHub

---

## Cara Instalasi Project

### 1. Clone Repository dan Masuk ke Folder Project

Clone repository project dengan perintah `git clone https://github.com/X-CHC/website-manajemen-bengkel-oji-jaya-motor.git`.

Setelah itu masuk ke folder project dengan perintah `cd nama-repository`.

Sesuaikan `nama-repository` dengan nama folder hasil clone project.

### 2. Install Dependency Laravel

Jalankan perintah `composer install`.

Perintah ini digunakan untuk menginstall dependency Laravel yang dibutuhkan oleh project.

### 3. Copy File Environment

Copy file `.env.example` menjadi `.env`.

Jika menggunakan terminal Git Bash atau Linux, jalankan `cp .env.example .env`.

Jika menggunakan Windows dan command tersebut tidak bisa, copy manual file `.env.example`, lalu ubah namanya menjadi `.env`.

### 4. Generate Application Key

Jalankan perintah `php artisan key:generate`.

Application key digunakan oleh Laravel untuk proses enkripsi dan keamanan aplikasi.

### 5. Buat Database

Buat database baru melalui phpMyAdmin, Laragon, HeidiSQL, atau MySQL.

Contoh nama database: `db_bengkel`.

### 6. Atur Konfigurasi Database

Buka file `.env`, lalu sesuaikan bagian database.

Contoh konfigurasi:

DB_DATABASE=db_bengkel

DB_USERNAME=root

DB_PASSWORD=

Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan konfigurasi database lokal masing-masing.

### 7. Atur Timezone

Agar waktu mengikuti WIB, pastikan konfigurasi timezone menggunakan Asia/Jakarta.

Pada file `.env`, tambahkan atau ubah menjadi `APP_TIMEZONE=Asia/Jakarta`.

Pada file `config/app.php`, bagian timezone dapat disesuaikan menjadi `'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta')`.

Setelah mengubah konfigurasi, jalankan `php artisan optimize:clear`.

### 8. Jalankan Migration

Jalankan perintah `php artisan migrate`.

Perintah ini digunakan untuk membuat tabel database berdasarkan file migration.

Jika ingin menjalankan migration dari awal dan menghapus seluruh isi tabel, jalankan `php artisan migrate:fresh`.

Perhatian: perintah `migrate:fresh` akan menghapus semua tabel dan data yang ada, lalu menjalankan ulang migration dari awal.

### 9. Jalankan Seeder

Untuk menjalankan seeder akun dan data awal, gunakan perintah `php artisan db:seed`.

Untuk menjalankan dummy data bengkel, gunakan perintah `php artisan db:seed --class=DummyBengkelSeeder`.

Catatan: Seeder dummy dapat mengosongkan beberapa tabel utama sebelum mengisi ulang data dummy. Gunakan hanya untuk kebutuhan testing atau demo.

### 10. Buat Storage Link

Jika project menggunakan upload file atau gambar melalui storage Laravel, jalankan `php artisan storage:link`.

Jika file upload disimpan langsung ke folder `public/assets`, pastikan folder tujuan sudah tersedia dan memiliki izin tulis.

### 11. Jalankan Server Lokal

Jalankan perintah `php artisan serve`.

Setelah server berjalan, buka aplikasi melalui browser dengan alamat `http://127.0.0.1:8000`.

---

## Akun Login Demo

Contoh akun login untuk demo:

Email: [admin@gmail.com](mailto:admin@gmail.com)

Password: 123

Role: Admin

Email: [kasir@gmail.com](mailto:kasir@gmail.com)

Password: 123

Role: Kasir

Email: [owner@gmail.com](mailto:owner@gmail.com)

Password: 123

Role: Owner

Email: [gudang@gmail.com](mailto:gudang@gmail.com)

Password: 123

Role: Gudang

---

## Cara Penggunaan Aplikasi

### 1. Login ke Sistem

Pengguna membuka halaman login, lalu memasukkan email dan password sesuai role yang dimiliki.

Setelah login berhasil, pengguna akan diarahkan ke halaman sesuai role masing-masing.

Contoh:

* Admin diarahkan ke dashboard
* Owner diarahkan ke dashboard atau laporan
* Kasir diarahkan ke transaksi
* Gudang diarahkan ke data barang atau fitur stok

Jika email atau password salah, sistem akan menampilkan notifikasi error.

### 2. Dashboard

Dashboard digunakan untuk menampilkan ringkasan informasi utama sistem.

Pada dashboard, pengguna dapat melihat informasi seperti:

* Pendapatan hari ini
* Jumlah transaksi hari ini
* Total pelanggan
* Grafik pendapatan
* Transaksi terbaru
* Pelanggan terbaru
* Barang terbaru
* Stok menipis atau stok habis sesuai hak akses

Dashboard tidak harus ditampilkan untuk semua role. Role tertentu seperti kasir atau gudang dapat diarahkan langsung ke fitur yang sesuai dengan tugasnya.

### 3. Mengelola Data Kategori Barang

Admin atau gudang dapat mengelola kategori barang melalui menu kategori.

Langkah penggunaan:

1. Masuk ke menu kategori barang.
2. Klik tombol tambah kategori.
3. Isi nama kategori barang.
4. Simpan data.
5. Data kategori akan tampil pada tabel.
6. Kategori dapat diedit jika diperlukan.
7. Kategori dapat dihapus jika belum digunakan oleh data barang.

Kategori barang digunakan untuk mengelompokkan data barang berdasarkan jenis tertentu.

### 4. Mengelola Data Barang

Admin atau gudang dapat mengelola data barang melalui menu barang.

Langkah penggunaan:

1. Masuk ke menu data barang.
2. Klik tombol tambah barang.
3. Pilih kategori barang.
4. Isi nama barang.
5. Isi harga beli, harga jual, stok awal, dan batas alert stok.
6. Simpan data barang.
7. Data barang akan tampil pada tabel.
8. Sistem akan menampilkan status stok, seperti aman, menipis, atau habis.

Pada fitur edit barang, data yang dapat diubah antara lain:

* Nama barang
* Kategori barang
* Harga beli
* Harga jual
* Batas alert stok

Stok barang tidak diedit langsung dari menu edit barang. Perubahan stok dilakukan melalui:

* Barang masuk
* Transaksi penjualan
* Stock opname

Data barang tidak dapat dihapus jika sudah digunakan pada transaksi, purchase order, atau barang masuk.

### 5. Mengelola Data Pelanggan

Admin atau kasir dapat mengelola data pelanggan melalui menu pelanggan.

Langkah penggunaan:

1. Masuk ke menu pelanggan.
2. Klik tombol tambah pelanggan.
3. Isi data pelanggan, seperti nama pelanggan, plat nomor, merek motor, dan warna motor.
4. Simpan data.
5. Data pelanggan akan tampil pada tabel.
6. Data pelanggan dapat diedit jika diperlukan.
7. Data pelanggan dapat dihapus jika belum pernah digunakan pada transaksi.

Data pelanggan digunakan pada proses transaksi penjualan, terutama jika transaksi dilakukan oleh pelanggan yang sudah terdaftar.

### 6. Membuat Purchase Order

Admin atau gudang dapat membuat purchase order untuk mencatat rencana pembelian barang dari mitra atau supplier.

Langkah penggunaan:

1. Masuk ke menu purchase order.
2. Klik tombol tambah purchase order.
3. Isi nama mitra atau supplier.
4. Tambahkan barang yang akan dipesan.
5. Masukkan jumlah barang yang dipesan.
6. Simpan purchase order.
7. Data purchase order akan tersimpan dengan status pending.

Purchase order digunakan sebagai dokumen awal sebelum proses penerimaan barang.

Aturan purchase order:

* PO dengan status pending dapat diedit atau dihapus.
* PO dengan status selesai tidak dapat diedit atau dihapus.
* PO akan berubah menjadi selesai setelah diproses pada fitur barang masuk.

### 7. Mencatat Barang Masuk

Admin atau gudang dapat mencatat barang masuk berdasarkan purchase order.

Langkah penggunaan:

1. Masuk ke menu barang masuk.
2. Klik tombol tambah barang masuk.
3. Pilih purchase order yang masih berstatus pending.
4. Sistem akan menampilkan daftar barang dari purchase order.
5. Masukkan jumlah barang yang benar-benar masuk.
6. Masukkan harga beli.
7. Upload bukti bayar.
8. Simpan data barang masuk.
9. Sistem akan menambah stok barang.
10. Sistem akan mencatat perubahan stok ke history stok.
11. Status purchase order akan berubah menjadi selesai.

Barang masuk bersifat final karena sudah memengaruhi stok, history stok, dan status purchase order.

Jika terdapat perbedaan antara jumlah PO dan jumlah barang yang masuk, sistem tetap mencatat jumlah barang yang benar-benar diterima.

### 8. Melakukan Transaksi Penjualan

Admin atau kasir dapat melakukan transaksi penjualan melalui menu transaksi.

Langkah penggunaan:

1. Masuk ke menu transaksi.
2. Klik tombol tambah transaksi.
3. Pilih pelanggan jika pelanggan sudah terdaftar.
4. Jika pelanggan tidak terdaftar, isi nama pelanggan secara manual jika diperlukan.
5. Pilih barang yang akan dijual.
6. Masukkan jumlah barang yang dibeli.
7. Sistem akan menghitung subtotal.
8. Masukkan harga jasa jika ada.
9. Masukkan uang bayar.
10. Sistem akan menghitung total harga dan uang kembali.
11. Simpan transaksi.
12. Sistem akan mengurangi stok barang.
13. Sistem akan mencatat perubahan stok ke history stok.
14. Nota transaksi dapat dicetak setelah transaksi selesai.

Aturan transaksi:

* Barang dengan stok habis tidak dapat dipilih.
* Jumlah barang yang dijual tidak boleh melebihi stok.
* Uang bayar tidak boleh kurang dari total harga.

### 9. Mencetak Nota Transaksi

Setelah transaksi penjualan selesai, pengguna dapat mencetak nota transaksi.

Langkah penggunaan:

1. Masuk ke menu transaksi.
2. Pilih transaksi yang ingin dicetak.
3. Klik tombol cetak nota.
4. Sistem akan menampilkan nota transaksi.
5. Nota dapat dicetak atau disimpan sebagai PDF.

Nota transaksi berisi informasi seperti:

* Nomor transaksi
* Tanggal transaksi
* Nama pelanggan
* Daftar barang yang dibeli
* Jumlah barang
* Harga barang
* Subtotal
* Harga jasa
* Total pembayaran
* Uang bayar
* Uang kembali

### 10. Melihat History Stok

Admin atau gudang dapat melihat riwayat perubahan stok barang melalui menu history stok.

History stok mencatat perubahan stok dari:

* Stok awal barang
* Barang masuk
* Transaksi penjualan
* Stock opname

Informasi yang ditampilkan meliputi:

* Tanggal
* Nama barang
* Jumlah masuk
* Jumlah keluar
* Jumlah sisa

History stok digunakan untuk melacak perubahan stok agar data stok lebih mudah diperiksa.

### 11. Stock Opname

Stock opname digunakan untuk mencocokkan stok sistem dengan stok fisik di bengkel.

Konsep stock opname:

* Jika stok fisik lebih besar dari stok sistem, sistem akan mencatat penambahan stok ke history stok.
* Jika stok fisik lebih kecil dari stok sistem, sistem akan mencatat pengurangan stok ke history stok.
* Jika stok fisik sama dengan stok sistem, stok tidak berubah.

Stock opname tidak menggunakan tabel khusus, tetapi langsung memperbarui stok pada tabel barang dan mencatat perubahan ke history stok.

### 12. Notifikasi Stok Menipis dan Stok Habis

Sistem menampilkan informasi stok barang yang sudah menipis atau habis.

Notifikasi dapat dilihat pada:

* Halaman data barang
* Dashboard sesuai hak akses

Pada halaman data barang, sistem menampilkan:

* Peringatan stok menipis atau habis
* Status stok setiap barang
* Penanda visual untuk barang yang stoknya menipis atau habis

Barang dianggap menipis jika stok barang kurang dari atau sama dengan batas alert stok.

### 13. Export Laporan PDF

Admin atau owner dapat mencetak laporan dalam bentuk PDF.

Konsep laporan PDF:

* PDF digunakan untuk rekap atau ringkasan laporan.
* PDF laporan transaksi menampilkan rekap barang terjual.
* PDF tidak menampilkan seluruh data tabel mentah.

Langkah penggunaan:

1. Masuk ke menu laporan.
2. Pilih jenis laporan transaksi.
3. Pilih tanggal awal dan tanggal akhir.
4. Pilih kategori atau barang jika diperlukan.
5. Klik tombol export PDF.
6. Sistem akan menghasilkan file laporan PDF.

Laporan PDF digunakan sebagai dokumen laporan yang siap dicetak.

### 14. Export Laporan Excel

Admin atau owner dapat mengekspor laporan dalam bentuk Excel.

Konsep laporan Excel:

* Excel digunakan untuk data detail atau tabel mentah.
* Excel dapat digunakan untuk laporan transaksi, barang masuk, dan history stok.
* Excel dapat difilter berdasarkan tanggal, kategori, dan barang.

Langkah penggunaan:

1. Masuk ke menu laporan.
2. Pilih jenis laporan.
3. Pilih tanggal awal dan tanggal akhir.
4. Pilih kategori jika diperlukan.
5. Pilih satu atau beberapa barang jika diperlukan.
6. Klik tombol export Excel.
7. Sistem akan mengunduh file laporan Excel.

Laporan Excel digunakan untuk kebutuhan pengolahan data lebih lanjut.

### 15. Mengelola Akun Pengguna

Admin dapat mengelola akun pengguna sistem.

Fitur akun meliputi:

* Menambah akun pengguna
* Memilih role pengguna
* Mengubah email pengguna
* Mengubah password pengguna jika diperlukan
* Menghapus akun pengguna tertentu

Akun yang sedang login tidak dapat menghapus dirinya sendiri.

### 16. Logout dari Sistem

Setelah selesai menggunakan aplikasi, pengguna dapat logout dari sistem.

Langkah penggunaan:

1. Klik tombol logout pada navbar.
2. Sistem akan menghapus session login.
3. Pengguna akan diarahkan kembali ke halaman login.
4. Pengguna harus login kembali untuk mengakses sistem.

---

## Alur Singkat Sistem

Alur penggunaan sistem secara umum:

Login

↓

Kelola data master

↓

Buat purchase order

↓

Catat barang masuk berdasarkan purchase order

↓

Stok barang bertambah

↓

Lakukan transaksi penjualan

↓

Stok barang berkurang

↓

History stok tercatat

↓

Stock opname jika ada koreksi stok

↓

Cetak nota dan laporan

---

## Struktur Fitur

### Data Master

* Data barang
* Data kategori barang
* Data pelanggan
* Data akun pengguna

### Transaksi dan Stok

* Purchase order
* Barang masuk
* Transaksi penjualan
* History stok barang
* Stock opname

### Laporan

* Laporan transaksi
* Laporan barang masuk
* Laporan history stok
* Export PDF
* Export Excel

---

## Status Project

Project ini masih dalam tahap pengembangan dan penyempurnaan untuk kebutuhan skripsi.

Beberapa bagian dapat disesuaikan kembali berdasarkan hasil bimbingan, seperti:

* Penyesuaian alur sistem
* Perapihan tampilan
* Penambahan validasi input
* Penyempurnaan laporan
* Penyesuaian role pengguna
* Penyesuaian struktur database

---

## Catatan

Beberapa hal yang perlu diperhatikan saat menjalankan project:

* Pastikan file `.env` sudah dibuat.
* Pastikan konfigurasi database sudah sesuai.
* Jalankan `composer install` setelah clone project.
* Jalankan `php artisan key:generate` sebelum menjalankan aplikasi.
* Jalankan migration sebelum menggunakan aplikasi.
* Gunakan seeder dummy hanya untuk testing atau demo.
* Jangan upload file `.env` ke repository publik.
* Jangan menampilkan akun atau password pribadi pada README.
* Jangan menghapus file penting pada folder `public/assets` jika digunakan untuk upload gambar atau bukti bayar.

---

## Author

Nama: Sofyan Wirawan
Project: Sistem Informasi Manajemen Bengkel
