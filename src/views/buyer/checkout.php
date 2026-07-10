<h3>Checkout</h3>
<div class="card">
    <div class="card-body">
        <p>Subtotal: <b><?= money($subtotal) ?></b></p>
        <p>Ongkir sederhana: <b><?= money($shipping) ?></b> <small class="text-muted">Gratis ongkir minimal
                Rp100.000</small></p>
        <h4>Total Bayar: <?= money($total) ?></h4>
        <form method="post"><button class="btn btn-success">Buat Pesanan</button></form>
    </div>
</div>