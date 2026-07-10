<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3>Register Seller</h3>
                <p class="text-muted">Setelah daftar, akun menunggu verifikasi admin.</p><?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                <form method="post"><input class="form-control mb-3" name="name" placeholder="Nama Toko / Seller"
                        required><input class="form-control mb-3" type="email" name="email" placeholder="Email"
                        required><input class="form-control mb-3" type="password" name="password" placeholder="Password"
                        required><button class="btn btn-success w-100">Daftar Seller</button></form>
            </div>
        </div>
    </div>
</div>