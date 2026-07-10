<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Reset Password - FreshMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <h3 class="mb-3 text-center">Reset Password</h3>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?= e($error) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <?= e($success) ?>
                            </div>

                            <a href="index.php?page=login" class="btn btn-success w-100">
                                Login Sekarang
                            </a>
                        <?php else: ?>

                            <form method="POST" action="index.php?page=reset-password">
                                <input
                                    type="hidden"
                                    name="token"
                                    value="<?= e($token ?? '') ?>"
                                >

                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Masukkan password baru"
                                        required
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>

                                    <input
                                        type="password"
                                        name="confirm_password"
                                        class="form-control"
                                        placeholder="Ulangi password baru"
                                        required
                                    >
                                </div>

                                <button class="btn btn-success w-100" type="submit">
                                    Simpan Password Baru
                                </button>
                            </form>

                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>