<h3>Tambah Produk</h3>

<form method="post" enctype="multipart/form-data">

    <label class="form-label">Kategori</label>
    <select class="form-select mb-3" name="category_id" required>
        <option value="">-- Pilih Kategori --</option>

        <?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <option
                value="<?= (int) $c['id'] ?>"
                <?= isset($product) && $product['category_id'] == $c['id'] ? 'selected' : '' ?>
            >
                <?= e($c['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label class="form-label">Nama Produk</label>
    <input
        class="form-control mb-3"
        type="text"
        name="name"
        value="<?= e($product['name'] ?? '') ?>"
        required
    >

    <label class="form-label">Berat / Ukuran</label>
    <input
        class="form-control mb-3"
        type="text"
        name="weight_size"
        placeholder="Contoh: 1 kg, 500 gram, 1 liter"
        value="<?= e($product['weight_size'] ?? '') ?>"
        required
    >

    <label class="form-label">Deskripsi</label>
    <textarea
        class="form-control mb-3"
        name="description"
        rows="4"
    ><?= e($product['description'] ?? '') ?></textarea>

    <label class="form-label">Harga</label>
    <input
        class="form-control mb-3"
        type="number"
        name="price"
        min="0"
        value="<?= e($product['price'] ?? '') ?>"
        required
    >

    <label class="form-label">Stok</label>
    <input
        class="form-control mb-3"
        type="number"
        name="stock"
        min="0"
        value="<?= e($product['stock'] ?? '') ?>"
        required
    >

    <label class="form-label">Gambar</label>
    <input
        class="form-control mb-3"
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png,.webp"
    >

    <button class="btn btn-success" type="submit">
        Simpan
    </button>

</form>