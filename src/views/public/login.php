<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Login</h3><?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
                <form method="post"><label>Email</label><input class="form-control mb-3" type="email" name="email"
                        required><label>Password</label><input class="form-control mb-3" type="password" name="password"
                        required><button class="btn btn-success w-100">Login</button></form>
                                            <div class="text-center mt-3">
                        <a href="index.php?page=forgot-password" class="text-success">
                            Lupa Password?
                        </a>
                    </div>
            </div>
        </div>
    </div>
</div>