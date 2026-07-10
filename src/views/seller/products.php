<div class="d-flex justify-content-between mb-3">
    <h3>Produk Saya</h3><a class="btn btn-success" href="index.php?page=seller-add-product">Tambah Produk</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody><?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?= e($p['name']) ?></td>
                <td><?= e($p['category']) ?></td>
                <td><?= money($p['price']) ?></td>
                <td><?= $p['stock'] ?></td>
                <td><a class="btn btn-sm btn-warning" href="index.php?page=seller-edit-product&id=<?= $p['id'] ?>">Edit</a> <a
                        onclick="return confirm('Hapus produk?')" class="btn btn-sm btn-danger"
                        href="index.php?page=seller-delete-product&id=<?= $p['id'] ?>">Hapus</a></td>
            </tr><?php endwhile; ?>
    </tbody>
</table>