# FreshMart Online

FreshMart Online adalah project e-commerce sederhana berbasis PHP Native dan MySQL yang dibuat untuk Tugas Besar Pemrograman Web.

Website ini digunakan untuk menjual produk segar seperti buah, sayur, daging, ikan, telur, susu, bumbu dapur, dan kebutuhan harian.

## Teknologi

Frontend:

- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- AJAX

Backend:

- PHP Native
- MySQL

Development environment:

- XAMPP
- phpMyAdmin

## Struktur Project

Project ini tidak menggunakan controller untuk seluruh fitur.

Folder `src/controllers/` hanya berisi:

```text
AuthController.php
```

`AuthController.php` digunakan untuk:

- Login
- Register buyer
- Register seller
- Logout

Fitur lain seperti produk, kategori, keranjang, checkout, pembayaran, tracking, seller, dan admin diproses langsung melalui `index.php`.

Struktur ini dipilih supaya alur program lebih sederhana dan mudah dijelaskan saat presentasi.

## Cara Instalasi

1. Salin folder `FreshMart-Online` ke:

```text
C:\xampp\htdocs\
```

2. Jalankan Apache dan MySQL dari XAMPP.

3. Buka phpMyAdmin.

4. Import file:

```text
database/database.sql
```

5. Pastikan file gambar produk berada di:

```text
src/uploads/products/
```

6. Buka website melalui browser:

```text
http://localhost/FreshMart-Online/
```

## Akun Demo

Semua akun menggunakan password:

```text
password
```

| Role | Nama | Email |
|---|---|---|
| Admin | Admin FreshMart | `admin@freshmart.test` |
| Buyer | Buyer Demo | `buyer@freshmart.test` |
| Seller | Seller Sayur Segar | `seller@freshmart.test` |
| Seller | Toko Buah Segar | `buah@freshmart.test` |
| Seller | Sayur Nusantara | `sayur@freshmart.test` |
| Seller | Daging Pilihan | `daging@freshmart.test` |
| Seller | Laut Segar | `ikan@freshmart.test` |
| Seller | Daily Fresh Store | `harian@freshmart.test` |

## Kategori Produk

FreshMart Online memiliki kategori:

1. Buah-buahan
2. Sayur-sayuran
3. Daging
4. Ikan & Seafood
5. Produk Susu
6. Telur
7. Bumbu Dapur
8. Produk Harian

Kategori dikelola oleh admin dan otomatis muncul pada form tambah produk seller.

## Fitur Pembeli

- Register dan login.
- Melihat semua produk.
- Melakukan pencarian produk.
- Memfilter produk berdasarkan kategori.
- Melihat detail produk.
- Menambah produk ke keranjang.
- Mengubah jumlah produk menggunakan AJAX.
- Menghapus produk dari keranjang.
- Checkout.
- Upload bukti pembayaran.
- Tracking pesanan.
- Melihat riwayat pesanan.
- Memberikan review dan rating.
- Melihat notifikasi.

## Fitur Seller

- Register seller.
- Login seller.
- Menunggu verifikasi admin.
- Melihat dashboard seller.
- Menambah produk.
- Mengedit produk.
- Menghapus produk.
- Mengelola stok.
- Melihat pesanan masuk.
- Mengubah status pesanan.
- Melihat total produk, jumlah pesanan, dan total penjualan.

## Fitur Admin

- Login admin.
- Melihat dashboard admin.
- Mengelola user.
- Memverifikasi seller.
- Mengelola kategori.
- Mengelola produk.
- Mengelola pesanan.
- Mengelola pembayaran.
- Melihat laporan sederhana.

## System Automation

Fitur otomatis yang sudah diterapkan:

- Mengurangi stok setelah checkout berhasil.
- Menghitung subtotal dan total belanja.
- Menghitung ongkir sederhana.
- Membuat nomor pesanan otomatis.
- Membuat notifikasi internal.
- Mengubah status pesanan saat pembayaran dikonfirmasi.

Catatan:

- Email notification melalui SMTP belum diterapkan.
- Invoice PDF belum diterapkan.
- Sistem saat ini menggunakan notifikasi internal dan nomor pesanan otomatis.

## AJAX

AJAX digunakan pada halaman keranjang untuk memperbarui jumlah produk tanpa me-reload seluruh halaman.

File JavaScript:

```text
src/assets/js/cart.js
```

Endpoint proses:

```text
index.php?page=update-cart
```

AJAX memperbarui:

- Quantity produk.
- Subtotal produk.
- Total keranjang.

## XSS Protection

Perlindungan XSS menggunakan fungsi:

```php
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
```

Fungsi `e()` digunakan saat menampilkan data dari database atau input pengguna ke halaman HTML.

Contoh:

```php
<?= e($product['name']) ?>
<?= e($review['comment']) ?>
<?= e($user['name']) ?>
```

Dengan cara tersebut, tag HTML atau JavaScript berbahaya tidak dijalankan oleh browser dan hanya ditampilkan sebagai teks biasa.

## Session Management

Session digunakan untuk:

- Menyimpan data user yang sedang login.
- Menyimpan data keranjang.
- Membatasi halaman berdasarkan role.
- Menampilkan pesan sukses atau error.

Contoh role:

```text
buyer
seller
admin
```

## Upload File

Upload file digunakan untuk:

- Gambar produk.
- Bukti pembayaran.

Folder upload:

```text
src/uploads/products/
src/uploads/payments/
```

Format gambar yang diterima:

- JPG
- JPEG
- PNG
- WEBP

## Database

Database menggunakan nama:

```text
freshmart_online
```

Dokumentasi lengkap database tersedia pada:

```text
docs/DATABASE_SCHEMA.md
```

## Dokumentasi Tambahan

- `docs/DATABASE_SCHEMA.md`
- `docs/AJAX_XSS_NOTE.md`
- `docs/USER_MANUAL.md`

## Catatan Presentasi

Alur demo yang disarankan:

1. Login buyer.
2. Pilih kategori dan produk.
3. Tambahkan produk ke keranjang.
4. Update quantity dengan AJAX.
5. Checkout dan upload bukti pembayaran.
6. Login admin dan konfirmasi pembayaran.
7. Login seller dan proses pesanan.
8. Tampilkan tracking pesanan.
9. Demonstrasikan perlindungan XSS.

## Pengembangan Selanjutnya

Project masih dapat dikembangkan dengan fitur:

- Email notification menggunakan PHPMailer atau SMTP.
- Invoice PDF.
- Payment gateway.
- API ongkir.
- Chat pembeli dan seller.
- Alamat pengiriman.
- Profil toko seller.
- Foto profil pengguna.
- Deployment ke hosting.
