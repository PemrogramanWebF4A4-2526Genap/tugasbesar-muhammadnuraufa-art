<?php if (!$product): ?>

    <div class="alert alert-warning">
        Produk tidak ditemukan.
    </div>

<?php else: ?>

    <?php
    $currentUser = $_SESSION['user'] ?? null;

    if (!is_array($currentUser)) {
        $currentUser = null;
    }

    $stock = (int) ($product['stock'] ?? 0);
    ?>

    <div class="row">

        <div class="col-md-5">
            <img class="img-fluid rounded shadow-sm w-100" src="src/uploads/products/<?= e($product['image']) ?>"
                alt="<?= e($product['name']) ?>" style="max-height: 420px; object-fit: cover;">
        </div>

        <div class="col-md-7">

            <h2><?= e($product['name']) ?></h2>

            <p class="mb-3">
                <span class="badge bg-success">
                    <?= e($product['category']) ?>
                </span>

                <span class="ms-1">
                    Seller: <?= e($product['seller_name']) ?>
                </span>
            </p>

            <h3 class="text-success mb-3">
                <?= money($product['price']) ?>
            </h3>

            <?php if (!empty($product['weight_size'])): ?>
                <p>
                    <strong>Berat / Ukuran:</strong>
                    <?= e($product['weight_size']) ?>
                </p>
            <?php endif; ?>

            <p>
                <?= nl2br(e($product['description'])) ?>
            </p>

            <p>
                <strong>Stok:</strong>
                <?= $stock ?>
            </p>

            <div class="mt-4">

                <?php if ($stock <= 0): ?>

                    <button class="btn btn-secondary btn-lg" disabled>
                        Stok Habis
                    </button>

                <?php elseif (!$currentUser): ?>

                    <a href="index.php?page=login" class="btn btn-success btn-lg me-2">
                        🛒 Tambah ke Keranjang
                    </a>

                    <a href="index.php?page=register" class="btn btn-outline-success btn-lg">
                        Register
                    </a>

                    <p class="text-muted small mt-2 mb-0">
                        Silakan login atau register terlebih dahulu untuk membeli produk.
                    </p>

                <?php elseif (($currentUser['role'] ?? '') === 'buyer'): ?>

                    <form method="post" action="index.php?page=add-cart">

                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">

                        <div class="input-group mb-3" style="max-width: 220px;">
                            <span class="input-group-text">Qty</span>

                            <input class="form-control" type="number" name="quantity" value="1" min="1" max="<?= $stock ?>"
                                required>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">
                            🛒 Tambah ke Keranjang
                        </button>

                    </form>

                <?php endif; ?>
            </div>

        </div>

    </div>

    <hr class="my-4">

    <h4 class="mb-3">
        Review Produk
    </h4>

    <?php if ($currentUser && ($currentUser['role'] ?? '') === 'buyer'): ?>

        <form class="card card-body mb-3" method="post" action="index.php?page=review">

            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">

            <label class="form-label">
                Rating
            </label>

            <select class="form-select mb-2" name="rating" required>
                <option value="5">5 - Sangat baik</option>
                <option value="4">4 - Baik</option>
                <option value="3">3 - Cukup</option>
                <option value="2">2 - Kurang</option>
                <option value="1">1 - Buruk</option>
            </select>

            <label class="form-label">
                Komentar
            </label>

            <textarea class="form-control mb-2" name="comment" rows="3" placeholder="Tulis komentar" required></textarea>

            <button type="submit" class="btn btn-outline-success">
                Kirim Review
            </button>

        </form>

    <?php elseif (!$currentUser): ?>

        <p class="text-muted">
            Login sebagai buyer untuk memberikan review produk.
        </p>

    <?php endif; ?>

    <?php while ($r = mysqli_fetch_assoc($reviews)): ?>

        <div class="border rounded p-3 mb-2">

            <div class="d-flex justify-content-between align-items-center">
                <b><?= e($r['user_name']) ?></b>

                <span>
                    ⭐ <?= (int) $r['rating'] ?>/5
                </span>
            </div>

            <p class="mb-0 mt-2">
                <?= nl2br(e($r['comment'])) ?>
            </p>

        </div>

    <?php endwhile; ?>

<?php endif; ?>