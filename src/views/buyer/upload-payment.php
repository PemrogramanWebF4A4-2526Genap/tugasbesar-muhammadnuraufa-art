<h3>Upload Bukti Pembayaran</h3>
<div class="card">
    <div class="card-body">
        <p>Nomor Pesanan: <b><?= e($order['order_number']) ?></b></p>
        <p>Total: <b><?= money($order['total_amount']) ?></b></p>
        <form method="post" enctype="multipart/form-data"><input type="hidden" name="order_id"
                value="<?= $order['id'] ?>"><label>Metode Pembayaran</label><select class="form-select mb-3"
                name="payment_method">
                <option>Transfer Bank</option>
                <option>QRIS</option>
                <option>DANA</option>
                <option>GoPay</option>
            </select><label>Bukti Pembayaran</label><input class="form-control mb-3" type="file" name="proof"
                required><button class="btn btn-success">Upload</button></form>
    </div>
</div>