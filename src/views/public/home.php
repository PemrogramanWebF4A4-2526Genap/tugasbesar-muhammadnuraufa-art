<?php
$categories = [
    [
        'name' => 'Buah-buahan',
        'image' => 'src/assets/images/categories/buah.png',
        'slug' => 'Buah-buahan'
    ],
    [
        'name' => 'Sayur-sayuran',
        'image' => 'src/assets/images/categories/sayur.png',
        'slug' => 'Sayur-sayuran'
    ],
    [
        'name' => 'Daging',
        'image' => 'src/assets/images/categories/daging.png',
        'slug' => 'Daging'
    ],
    [
        'name' => 'Ikan & Seafood',
        'image' => 'src/assets/images/categories/ikan.png',
        'slug' => 'Ikan & Seafood'
    ],
    [
        'name' => 'Produk Susu',
        'image' => 'src/assets/images/categories/susu.png',
        'slug' => 'Produk Susu'
    ],
    [
        'name' => 'Telur',
        'image' => 'src/assets/images/categories/telur.png',
        'slug' => 'Telur'
    ],
    [
        'name' => 'Bumbu Dapur',
        'image' => 'src/assets/images/categories/bumbu.png',
        'slug' => 'Bumbu Dapur'
    ],
    [
        'name' => 'Produk Harian',
        'image' => 'src/assets/images/categories/harian.png',
        'slug' => 'Produk Harian'
    ]
];
?>

<!-- HERO -->
<section class="hero rounded-4 p-5 mb-4">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="fw-bold">
                Belanja Produk Segar Lebih Mudah
            </h1>

            <p class="lead">
                Sayur, buah, daging, dan produk harian dari penjual terpercaya.
            </p>

            <a
                class="btn btn-success btn-lg"
                href="index.php?page=products"
            >
                Mulai Belanja
            </a>

            <a
                class="btn btn-outline-success btn-lg ms-2"
                href="index.php?page=register-seller"
            >
                Daftar Seller
            </a>
        </div>

        <div class="col-md-5 text-center">
            <div class="display-1">🥦🍎🥩</div>
        </div>
    </div>
</section>

<!-- KATEGORI -->
<section class="mb-4">
    <div class="bg-white rounded-3 shadow-sm overflow-hidden">

        <div class="px-4 py-3 border-bottom">
            <h5 class="mb-0 fw-bold text-dark">
                Kategori Produk
            </h5>
        </div>

        <div class="row g-0">
            <?php foreach ($categories as $category): ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                    <a
                        href="index.php?page=products&category=<?= urlencode($category['slug']) ?>"
                        class="d-flex flex-column align-items-center justify-content-center text-decoration-none border-end border-bottom bg-white"
                        style="height: 155px; color: #222;"
                    >
                        <img
                            src="<?= e($category['image']) ?>"
                            alt="<?= e($category['name']) ?>"
                            style="
                                width: 80px !important;
                                height: 80px !important;
                                max-width: 80px !important;
                                max-height: 80px !important;
                                object-fit: cover;
                                border-radius: 50%;
                                display: block;
                                margin: 0 auto 10px;
                            "
                        >

                        <span
                            style="
                                color: #222222 !important;
                                font-size: 14px;
                                font-weight: 500;
                                text-align: center;
                            "
                        >
                            <?= e($category['name']) ?>
                        </span>
                    </a>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- PRODUK TERBARU -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Produk Terbaru</h3>

    <a
        href="index.php?page=products"
        class="text-success text-decoration-none"
    >
        Lihat Semua
    </a>
</div>

<div class="row g-3">
    <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <div class="col-6 col-md-3">
            <div class="card product-card h-100">

                <img
                    class="card-img-top"
                    src="src/uploads/products/<?= e($p['image']) ?>"
                    alt="<?= e($p['name']) ?>"
                >

                <div class="card-body">
                    <span class="badge bg-success-subtle text-success">
                        <?= e($p['category']) ?>
                    </span>

                    <h6 class="mt-2">
                        <?= e($p['name']) ?>
                    </h6>

                    <p class="fw-bold text-success">
                        <?= money($p['price']) ?>
                    </p>

                    <a
                        class="btn btn-sm btn-success w-100"
                        href="index.php?page=product-detail&id=<?= (int) $p['id'] ?>"
                    >
                        Detail
                    </a>
                </div>

            </div>
        </div>
    <?php endwhile; ?>
</div>