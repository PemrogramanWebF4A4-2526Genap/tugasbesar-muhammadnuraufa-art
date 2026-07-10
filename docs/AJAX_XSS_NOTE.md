# Catatan AJAX dan XSS Protection

## AJAX
Project FreshMart Online sudah memakai AJAX pada fitur keranjang belanja.

File yang dipakai:

- `src/assets/js/cart.js`
- `index.php?page=update-cart`
- `src/views/buyer/cart.php`

Cara kerjanya:

1. Pembeli mengubah jumlah barang di halaman keranjang.
2. JavaScript `fetch()` mengirim data `id` produk dan `quantity` ke `index.php?page=update-cart` tanpa reload halaman.
3. PHP menghitung subtotal dan total baru.
4. PHP mengembalikan response JSON.
5. JavaScript mengganti tampilan subtotal dan total secara otomatis.

Contoh kode AJAX ada di `src/assets/js/cart.js`.

## XSS Protection
Project ini juga sudah diberi perlindungan dasar terhadap XSS Injection.

Fungsi utama ada di `index.php`:

```php
function e($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
```

Fungsi `e()` dipakai saat menampilkan data dari database atau input user ke halaman HTML, misalnya:

```php
<?= e($product['name']) ?>
<?= e($review['comment']) ?>
<?= e($user['name']) ?>
```

Tujuannya agar input seperti:

```html
<script>alert('xss')</script>
```

tidak dijalankan sebagai JavaScript, tetapi hanya ditampilkan sebagai teks biasa.

## Contoh Pengujian XSS
Untuk testing, coba masukkan kode berikut di nama produk, deskripsi produk, atau komentar review:

```html
<script>alert('xss')</script>
```

Hasil yang benar: alert tidak muncul, dan kode script hanya tampil sebagai teks.

## Catatan Presentasi
Kalimat singkat untuk dosen:

> Sistem ini memakai AJAX pada fitur update jumlah barang di keranjang, sehingga subtotal dan total berubah tanpa reload halaman. Untuk keamanan XSS, sistem menggunakan fungsi `e()` berbasis `htmlspecialchars()` saat menampilkan data user ke halaman HTML.
