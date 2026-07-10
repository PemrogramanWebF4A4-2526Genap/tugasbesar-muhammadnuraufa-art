<h3>Kelola Stok</h3>
<table class="table">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody><?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
                <td><?= e($p['name']) ?></td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <form class="d-flex" method="post"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><input
                            class="form-control me-2" style="width:100px" type="number" name="stock"
                            value="<?= $p['stock'] ?>"><button class="btn btn-sm btn-success">Update</button></form>
                </td>
            </tr><?php endwhile; ?>
    </tbody>
</table>