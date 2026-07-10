# Database Schema

Database yang digunakan pada project ini bernama `freshmart_online`.

## Struktur Tabel Utama

### 1. `users`

Tabel `users` digunakan untuk menyimpan seluruh data akun yang terdaftar di dalam sistem.

Field utama:

- `id`: primary key akun.
- `name`: nama pengguna.
- `email`: email pengguna dan harus unik.
- `password`: password yang sudah di-hash.
- `role`: jenis akun, yaitu `buyer`, `seller`, atau `admin`.
- `seller_status`: status verifikasi seller, yaitu `pending`, `approved`, atau `rejected`.
- `created_at`: waktu pembuatan akun.

### 2. `categories`

Tabel `categories` digunakan untuk menyimpan kategori produk.

Field utama:

- `id`: primary key kategori.
- `name`: nama kategori.
- `description`: deskripsi kategori.

Kategori yang tersedia:

- Buah-buahan
- Sayur-sayuran
- Daging
- Ikan & Seafood
- Produk Susu
- Telur
- Bumbu Dapur
- Produk Harian

### 3. `products`

Tabel `products` digunakan untuk menyimpan data produk yang dijual oleh seller.

Field utama:

- `id`: primary key produk.
- `seller_id`: foreign key yang mengarah ke tabel `users`.
- `category_id`: foreign key yang mengarah ke tabel `categories`.
- `name`: nama produk.
- `weight_size`: berat atau ukuran produk.
- `description`: deskripsi produk.
- `price`: harga produk.
- `stock`: jumlah stok produk.
- `image`: nama file gambar produk.
- `created_at`: waktu produk ditambahkan.

Relasi:

- Satu seller dapat memiliki banyak produk.
- Satu kategori dapat memiliki banyak produk.

### 4. `orders`

Tabel `orders` digunakan untuk menyimpan data utama pesanan pembeli.

Field utama:

- `id`: primary key pesanan.
- `order_number`: nomor pesanan otomatis.
- `buyer_id`: foreign key yang mengarah ke akun buyer pada tabel `users`.
- `total_amount`: total pembayaran.
- `shipping_cost`: biaya ongkir.
- `status`: status pesanan.
- `created_at`: waktu pesanan dibuat.

Status pesanan:

1. Menunggu Pembayaran
2. Pembayaran Dikonfirmasi
3. Sedang Diproses
4. Sedang Dikirim
5. Pesanan Diterima
6. Selesai

### 5. `order_items`

Tabel `order_items` digunakan untuk menyimpan rincian produk di dalam setiap pesanan.

Field utama:

- `id`: primary key detail pesanan.
- `order_id`: foreign key yang mengarah ke tabel `orders`.
- `product_id`: foreign key yang mengarah ke tabel `products`.
- `quantity`: jumlah produk yang dibeli.
- `price`: harga produk saat transaksi dilakukan.

Relasi:

- Satu pesanan dapat memiliki banyak item.
- Satu produk dapat muncul pada banyak detail pesanan.

### 6. `payments`

Tabel `payments` digunakan untuk menyimpan data pembayaran.

Field utama:

- `id`: primary key pembayaran.
- `order_id`: foreign key yang mengarah ke tabel `orders`.
- `payment_method`: metode pembayaran.
- `proof`: nama file bukti pembayaran.
- `status`: status pembayaran.
- `created_at`: waktu pembayaran dibuat.

Status pembayaran:

- Menunggu Konfirmasi
- Dikonfirmasi
- Ditolak

### 7. `reviews`

Tabel `reviews` digunakan untuk menyimpan rating dan komentar pembeli terhadap produk.

Field utama:

- `id`: primary key review.
- `product_id`: foreign key yang mengarah ke tabel `products`.
- `user_id`: foreign key yang mengarah ke tabel `users`.
- `rating`: nilai rating produk.
- `comment`: komentar pembeli.
- `created_at`: waktu review dibuat.

### 8. `notifications`

Tabel `notifications` digunakan untuk menyimpan notifikasi internal pengguna.

Field utama:

- `id`: primary key notifikasi.
- `user_id`: foreign key yang mengarah ke tabel `users`.
- `message`: isi notifikasi.
- `is_read`: status apakah notifikasi sudah dibaca.
- `created_at`: waktu notifikasi dibuat.

## Relasi Antar-Tabel

- `users.id` → `products.seller_id`
- `users.id` → `orders.buyer_id`
- `users.id` → `reviews.user_id`
- `users.id` → `notifications.user_id`
- `categories.id` → `products.category_id`
- `orders.id` → `order_items.order_id`
- `orders.id` → `payments.order_id`
- `products.id` → `order_items.product_id`
- `products.id` → `reviews.product_id`

## Data Dummy

Database terbaru berisi:

- 1 akun admin.
- 1 akun buyer.
- 6 akun seller.
- 8 kategori produk.
- 40 produk dummy.
- Notifikasi awal untuk akun demo.

Seluruh akun demo menggunakan password:

```text
password
```

## Catatan Field Tambahan

Beberapa field ditambahkan agar kebutuhan fitur website dapat berjalan:

- `seller_status` untuk proses verifikasi seller.
- `order_number` untuk nomor pesanan otomatis.
- `shipping_cost` untuk perhitungan ongkir.
- `weight_size` untuk menampilkan berat atau ukuran produk.
- `created_at` untuk mencatat waktu pembuatan data.

## Lokasi Gambar Produk

Nama file gambar disimpan di kolom `products.image`.

File gambar produk harus ditempatkan di:

```text
src/uploads/products/
```

Contoh nama file:

```text
buah.png
sayur.png
daging.png
ikan.png
susu.png
telur.png
bumbu.png
harian.png
```
