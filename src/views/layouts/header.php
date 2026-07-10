<?php
$user = $_SESSION['user'] ?? null;

if (!is_array($user)) {
    $user = null;
    unset($_SESSION['user']);
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreshMart Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/assets/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container"><a class="navbar-brand fw-bold" href="index.php">FreshMart</a><button
                class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?page=products">Produk</a></li>
                    <?php if ($user && $user['role'] === 'buyer'): ?>
                        <li><a class="nav-link" href="index.php?page=order-history">Pesanan</a></li>
                        <li><a class="nav-link" href="index.php?page=cart">🛒Keranjang</a></li>
                    <?php endif; ?>
                    <?php if ($user && $user['role'] === 'seller'): ?>
                        <li><a class="nav-link" href="index.php?page=seller-dashboard">Seller</a></li>
                    <?php endif; ?><?php if ($user && $user['role'] === 'admin'): ?>
                        <li><a class="nav-link" href="index.php?page=admin-dashboard">Admin</a></li><?php endif; ?>
                </ul>
                <ul class="navbar-nav"><?php if ($user): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=notifications">🔔</a></li>
                        <li class="nav-item"><span class="nav-link">Halo, <?= e($user['name']) ?></span></li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=profile">
                                Profil
                            </a>
                        </li>
                        <li><a class="btn btn-light btn-sm" href="index.php?page=logout">Logout</a></li><?php else: ?>
                        <li><a class="btn btn-light btn-sm me-2" href="index.php?page=login">Login</a></li>
                        <li><a class="btn btn-outline-light btn-sm" href="index.php?page=register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container"><?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= e($_SESSION['success']);
                unset($_SESSION['success']); ?></div>
            <?php endif; ?><?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= e($_SESSION['error']);
                unset($_SESSION['error']); ?></div><?php endif; ?>