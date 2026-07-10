<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">
            <?php if (!empty($category)): ?>
                Produk <?= e($category) ?>
            <?php else: ?>
                Semua Produk
            <?php endif; ?>
        </h3>

        <?php if (!empty($category)): ?>
            <p class="text-muted mb-0">
                Menampilkan produk kategori <?= e($category) ?>
            </p>
        <?php endif; ?>
    </div>

    <?php if (!empty($category) || !empty($keyword)): ?>
        <a href="index.php?page=products" class="btn btn-outline-success btn-sm">
            Tampilkan Semua
        </a>
    <?php endif; ?>
</div>

<form action="index.php" method="GET" class="row g-2 mb-4">
    <input type="hidden" name="page" value="products">

    <?php if (!empty($category)): ?>
        <input type="hidden" name="category" value="<?= e($category) ?>">
    <?php endif; ?>

    <div class="col-md-10">
        <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="<?= e($keyword ?? '') ?>">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">
            Cari
        </button>
    </div>
</form>

<div class="mb-4">
    <div class="d-flex flex-wrap gap-2">

        <a href="index.php?page=products" class="btn <?= empty($category) ? 'btn-success' : 'btn-outline-success' ?>">
            Semua
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Buah-buahan') ?>"
            class="btn <?= ($category ?? '') === 'Buah-buahan' ? 'btn-success' : 'btn-outline-success' ?>">
            Buah-buahan
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Sayur-sayuran') ?>"
            class="btn <?= ($category ?? '') === 'Sayur-sayuran' ? 'btn-success' : 'btn-outline-success' ?>">
            Sayur-sayuran
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Daging') ?>"
            class="btn <?= ($category ?? '') === 'Daging' ? 'btn-success' : 'btn-outline-success' ?>">
            Daging
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Ikan & Seafood') ?>"
            class="btn <?= ($category ?? '') === 'Ikan & Seafood' ? 'btn-success' : 'btn-outline-success' ?>">
            Ikan & Seafood
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Produk Susu') ?>"
            class="btn <?= ($category ?? '') === 'Produk Susu' ? 'btn-success' : 'btn-outline-success' ?>">
            Produk Susu
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Telur') ?>"
            class="btn <?= ($category ?? '') === 'Telur' ? 'btn-success' : 'btn-outline-success' ?>">
            Telur
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Bumbu Dapur') ?>"
            class="btn <?= ($category ?? '') === 'Bumbu Dapur' ? 'btn-success' : 'btn-outline-success' ?>">
            Bumbu Dapur
        </a>

        <a href="index.php?page=products&category=<?= urlencode('Produk Harian') ?>"
            class="btn <?= ($category ?? '') === 'Produk Harian' ? 'btn-success' : 'btn-outline-success' ?>">
            Produk Harian
        </a>

    </div>
</div>

<div class="row g-3">
    <?php if ($products && mysqli_num_rows($products) > 0): ?>

        <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">

                    <img src="src/uploads/products/<?= e($p['image']) ?>" class="card-img-top" alt="<?= e($p['name']) ?>">

                    <div class="card-body d-flex flex-column">

                        <span class="badge bg-success-subtle text-success align-self-start">
                            <?= e($p['category'] ?? 'Tanpa Kategori') ?>
                        </span>

                        <h6 class="mt-2 mb-1">
                            <?= e($p['name']) ?>
                        </h6>

                        <?php if (!empty($p['seller_name'])): ?>
                            <small class="text-muted mb-2">
                                Penjual: <?= e($p['seller_name']) ?>
                            </small>
                        <?php endif; ?>

                        <p class="fw-bold text-success mb-2">
                            <?= money($p['price']) ?>
                        </p>

                        <p class="small text-muted">
                            Stok: <?= (int) $p['stock'] ?>
                        </p>

                        <a href="index.php?page=product-detail&id=<?= (int) $p['id'] ?>"
                            class="btn btn-success btn-sm w-100 mt-auto">
                            Lihat Detail
                        </a>

                    </div>
                </div>
            </div>
        <?php endwhile; ?>

    <?php else: ?>

        <div class="col-12">
            <div class="alert alert-warning text-center">
                Tidak ada produk pada kategori ini.
            </div>
        </div>

    <?php endif; ?>
</div>