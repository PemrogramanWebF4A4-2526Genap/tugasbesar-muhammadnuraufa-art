<h3>Dashboard Seller</h3><?php if (($_SESSION['user']['seller_status'] ?? 'pending') !== 'approved'): ?>
    <div class="alert alert-warning">Akun seller kamu masih menunggu verifikasi admin. Fitur tambah produk dikunci
        sementara.</div><?php endif; ?>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card stat">
            <div class="card-body">
                <h6>Jumlah Produk</h6>
                <h2><?= $totalProducts ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat">
            <div class="card-body">
                <h6>Jumlah Pesanan</h6>
                <h2><?= $totalOrders ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat">
            <div class="card-body">
                <h6>Total Penjualan</h6>
                <h2><?= money($totalSales) ?></h2>
            </div>
        </div>
    </div>
</div>
<div class="mt-3"><a class="btn btn-success" href="index.php?page=seller-products">Kelola Produk</a> <a
        class="btn btn-outline-success" href="index.php?page=seller-orders">Pesanan Masuk</a> <a
        class="btn btn-outline-success" href="index.php?page=seller-stock">Kelola Stok</a></div>