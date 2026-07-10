<h3>Edit Produk</h3>
<form method="post" enctype="multipart/form-data">
    <label>Kategori</label><select class="form-select mb-3"
        name="category_id"><?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= $c['id'] ?>" <?= isset($product) && $product['category_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= e($c['name']) ?></option><?php endwhile; ?>
    </select><label>Nama Produk</label><input class="form-control mb-3" name="name" value="<?= e($product['name'] ?? '') ?>"
        required><label>Deskripsi</label><textarea class="form-control mb-3"
        name="description"><?= e($product['description'] ?? '') ?></textarea><label>Harga</label><input
        class="form-control mb-3" type="number" name="price" value="<?= $product['price'] ?? '' ?>"
        required><label>Stok</label><input class="form-control mb-3" type="number" name="stock"
        value="<?= $product['stock'] ?? '' ?>" required><label>Gambar</label><input class="form-control mb-3" type="file"
        name="image"><button class="btn btn-success">Simpan</button>
</form>