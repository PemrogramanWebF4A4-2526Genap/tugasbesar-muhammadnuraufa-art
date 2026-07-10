<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Lupa Password - FreshMart</title>
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

                        <h3 class="mb-3 text-center">Lupa Password</h3>

                        <p class="text-muted text-center">
                            Masukkan email akun kamu untuk membuat password baru.
                        </p>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?= e($error) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($resetLink)): ?>
                            <div class="alert alert-success">
                                Link reset password berhasil dibuat.
                            </div>

                            <div class="alert alert-warning">
                                <strong>Mode Demo:</strong><br>
                                Karena belum memakai email SMTP, klik link ini untuk reset password:
                                <br><br>

                                <a href="<?= e($resetLink) ?>">
                                    <?= e($resetLink) ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?page=forgot-password">
                            <div class="mb-3">
                                <label class="form-label">Email</label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Masukkan email"
                                    required
                                >
                            </div>

                            <button class="btn btn-success w-100" type="submit">
                                Buat Link Reset
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="index.php?page=login" class="text-success">
                                Kembali ke Login
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>