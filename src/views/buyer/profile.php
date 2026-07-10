<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Profil Saya</h4>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Nama</div>
            <div class="col-md-9"><?= e($user['name'] ?? '-') ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Email</div>
            <div class="col-md-9"><?= e($user['email'] ?? '-') ?></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Role</div>
            <div class="col-md-9"><?= e($user['role'] ?? '-') ?></div>
        </div>

        <?php if (($user['role'] ?? '') === 'buyer'): ?>
            <hr>

            <h5>Mulai Berjualan</h5>
            <p class="text-muted">
                Daftarkan akun Anda sebagai seller untuk mulai menjual produk di FreshMart.
            </p>

            <a href="index.php?page=register-seller" class="btn btn-success">
                Daftar Menjadi Seller
            </a>
        <?php endif; ?>

        <?php if (($user['role'] ?? '') === 'seller'): ?>
            <a href="index.php?page=seller-dashboard" class="btn btn-success">
                Buka Dashboard Seller
            </a>
        <?php endif; ?>
    </div>
</div>