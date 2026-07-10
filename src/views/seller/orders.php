<h3>Pesanan Masuk</h3>
<table class="table">
    <thead>
        <tr>
            <th>No Pesanan</th>
            <th>Pembeli</th>
            <th>Total</th>
            <th>Status</th>
            <th>Ubah Status</th>
        </tr>
    </thead>
    <tbody><?php while ($o = mysqli_fetch_assoc($orders)): ?>
            <tr>
                <td><?= e($o['order_number']) ?></td>
                <td><?= e($o['buyer_name']) ?></td>
                <td><?= money($o['total_amount']) ?></td>
                <td><?= e($o['status']) ?></td>
                <td>
                    <form class="d-flex" method="post" action="index.php?page=seller-update-order"><input type="hidden"
                            name="order_id" value="<?= $o['id'] ?>"><select class="form-select form-select-sm me-2"
                            name="status"><?php foreach (['Sedang Diproses', 'Sedang Dikirim', 'Pesanan Diterima', 'Selesai'] as $s): ?>
                                <option><?= e($s) ?></option><?php endforeach; ?>
                        </select><button class="btn btn-sm btn-success">Update</button></form>
                </td>
            </tr><?php endwhile; ?>
    </tbody>
</table>