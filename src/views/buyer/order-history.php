<h3>Riwayat Pesanan</h3>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody><?php while ($o = mysqli_fetch_assoc($orders)): ?>
            <tr>
                <td><?= e($o['order_number']) ?></td>
                <td><?= money($o['total_amount']) ?></td>
                <td><span class="badge bg-success"><?= e($o['status']) ?></span></td>
                <td><?= e($o['created_at']) ?></td>
                <td><a class="btn btn-sm btn-outline-success" href="index.php?page=tracking&id=<?= $o['id'] ?>">Tracking</a>
            </tr><?php endwhile; ?>
    </tbody>
</table>