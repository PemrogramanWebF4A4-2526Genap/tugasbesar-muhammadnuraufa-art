<?php
session_start();
require_once __DIR__ . '/src/config/database.php';
require_once __DIR__ . '/src/controllers/AuthController.php';

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = [];

$page = $_GET['page'] ?? 'home';

function view($path, $data = [], $useLayout = true)
{
    extract($data);

    if ($useLayout) {
        require __DIR__ . '/src/views/layouts/header.php';
    }

    require __DIR__ . '/src/views/' . $path . '.php';

    if ($useLayout) {
        require __DIR__ . '/src/views/layouts/footer.php';
    }
}
function redirect($page)
{
    header('Location: index.php?page=' . $page);
    exit;
}
function auth_required($role = null)
{
    if (!isset($_SESSION['user']))
        redirect('login');
    if ($role && $_SESSION['user']['role'] !== $role)
        redirect('home');
}
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function money($n)
{
    return 'Rp ' . number_format((float) $n, 0, ',', '.');
}
function order_number($id)
{
    return 'FM-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
}
function seller_approved()
{
    return ($_SESSION['user']['seller_status'] ?? 'pending') === 'approved';
}
function upload_file($field, $targetDir, $prefix, $default = '')
{
    if (empty($_FILES[$field]['name']))
        return $default;
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed))
        return $default;
    $filename = $prefix . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
    move_uploaded_file($_FILES[$field]['tmp_name'], __DIR__ . $targetDir . $filename);
    return $filename;
}

/*
  Catatan struktur:
  Project ini sengaja dibuat TANPA controller fitur.
  Controller yang dipakai hanya AuthController untuk login/register/logout.
  Fitur produk, keranjang, checkout, payment, seller, dan admin diproses langsung di index.php
  supaya lebih simpel dijelaskan saat presentasi tugas kuliah PHP Native.
*/

$auth = new AuthController($conn);

switch ($page) {
    case 'home':
        $products = mysqli_query($conn, "SELECT p.*, c.name category FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC LIMIT 8");
        view('public/home', compact('products'));
        break;

    case 'login':
        $auth->login();
        break;

    case 'forgot-password':
        $auth->forgotPassword();
        break;

    case 'reset-password':
        $auth->resetPassword();
        break;

    case 'register':
        $auth->register('buyer');
        break;

    case 'register-seller':
        $auth->register('seller');
        break;

    case 'logout':
        $auth->logout();
        break;

    case 'profile':
        auth_required();

        $userId = (int) $_SESSION['user']['id'];

        $user = mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "SELECT id, name, email, role, seller_status, created_at
             FROM users
             WHERE id=$userId
             LIMIT 1"
            )
        );

        if (!$user) {
            redirect('logout');
        }

        $_SESSION['user'] = array_merge($_SESSION['user'], $user);

        view('buyer/profile', compact('user'));
        break;

    case 'become-seller':
        auth_required('buyer');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('profile');
        }

        $userId = (int) $_SESSION['user']['id'];
        $sellerStatus = $_SESSION['user']['seller_status'] ?? '';

        if ($sellerStatus === 'pending') {
            $_SESSION['error'] = 'Pendaftaran seller kamu sedang menunggu verifikasi admin.';
            redirect('profile');
        }

        if ($sellerStatus === 'approved') {
            $_SESSION['error'] = 'Akun kamu sudah terdaftar sebagai seller.';
            redirect('profile');
        }

        mysqli_query(
            $conn,
            "UPDATE users
         SET seller_status='pending'
         WHERE id=$userId AND role='buyer'"
        );

        $_SESSION['user']['seller_status'] = 'pending';
        $_SESSION['success'] = 'Pendaftaran seller berhasil. Tunggu verifikasi admin.';

        redirect('profile');
        break;

    case 'products':
        $keyword = trim($_GET['q'] ?? '');
        $category = trim($_GET['category'] ?? '');

        $keywordSafe = mysqli_real_escape_string($conn, $keyword);
        $categorySafe = mysqli_real_escape_string($conn, $category);

        $conditions = [];

        if ($keywordSafe !== '') {
            $conditions[] = "(
            p.name LIKE '%$keywordSafe%'
            OR p.description LIKE '%$keywordSafe%'
            OR c.name LIKE '%$keywordSafe%'
        )";
        }

        if ($categorySafe !== '') {
            $conditions[] = "c.name = '$categorySafe'";
        }

        $where = '';

        if (!empty($conditions)) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $products = mysqli_query(
            $conn,
            "SELECT
            p.*,
            c.name AS category,
            u.name AS seller_name
         FROM products p
         LEFT JOIN categories c ON c.id = p.category_id
         LEFT JOIN users u ON u.id = p.seller_id
         $where
         ORDER BY p.id DESC"
        );

        view(
            'public/products',
            compact('products', 'keyword', 'category')
        );
        break;

    case 'product-detail':
        $id = (int) ($_GET['id'] ?? 0);
        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT p.*, c.name category, u.name seller_name FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN users u ON u.id=p.seller_id WHERE p.id=$id"));
        $reviews = mysqli_query($conn, "SELECT r.*, u.name user_name FROM reviews r JOIN users u ON u.id=r.user_id WHERE r.product_id=$id ORDER BY r.id DESC");
        view('public/product-detail', compact('product', 'reviews'));
        break;

    case 'add-cart':
        auth_required('buyer');
        $id = (int) $_POST['product_id'];
        $qty = max(1, (int) ($_POST['quantity'] ?? 1));
        $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));
        if ($p) {
            if (isset($_SESSION['cart'][$id]))
                $_SESSION['cart'][$id]['quantity'] += $qty;
            else
                $_SESSION['cart'][$id] = ['id' => $id, 'name' => $p['name'], 'price' => $p['price'], 'image' => $p['image'], 'quantity' => $qty];
            $_SESSION['success'] = 'Produk masuk keranjang.';
        }
        redirect('cart');
        break;

    case 'cart':
        auth_required('buyer');
        view('buyer/cart', ['cart' => $_SESSION['cart']]);
        break;

    case 'update-cart':
        auth_required('buyer');
        header('Content-Type: application/json');
        $id = (int) $_POST['id'];
        $qty = max(1, (int) $_POST['quantity']);
        if (isset($_SESSION['cart'][$id]))
            $_SESSION['cart'][$id]['quantity'] = $qty;
        $subtotal = 0;
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            if ($item['id'] == $id)
                $subtotal = $item['price'] * $item['quantity'];
            $total += $item['price'] * $item['quantity'];
        }
        echo json_encode(['subtotal' => $subtotal, 'total' => $total]);
        exit;

    case 'remove-cart':
        auth_required('buyer');
        unset($_SESSION['cart'][(int) $_GET['id']]);
        redirect('cart');
        break;

    case 'checkout':
        auth_required('buyer');
        if (empty($_SESSION['cart']))
            redirect('cart');
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $i)
            $subtotal += $i['price'] * $i['quantity'];
        $shipping = $subtotal >= 100000 ? 0 : 10000;
        $total = $subtotal + $shipping;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $buyer = $_SESSION['user']['id'];
            mysqli_query($conn, "INSERT INTO orders(buyer_id,total_amount,shipping_cost,status,created_at) VALUES($buyer,$total,$shipping,'Menunggu Pembayaran',NOW())");
            $order_id = mysqli_insert_id($conn);
            $number = order_number($order_id);
            mysqli_query($conn, "UPDATE orders SET order_number='$number' WHERE id=$order_id");
            foreach ($_SESSION['cart'] as $it) {
                $pid = $it['id'];
                $qty = $it['quantity'];
                $price = $it['price'];
                mysqli_query($conn, "INSERT INTO order_items(order_id,product_id,quantity,price) VALUES($order_id,$pid,$qty,$price)");
                mysqli_query($conn, "UPDATE products SET stock=GREATEST(stock-$qty,0) WHERE id=$pid");
            }
            mysqli_query($conn, "INSERT INTO notifications(user_id,message,is_read,created_at) VALUES($buyer,'Pesanan $number berhasil dibuat. Silakan upload bukti pembayaran.',0,NOW())");
            $_SESSION['cart'] = [];
            redirect('upload-payment&id=' . $order_id);
        }
        view('buyer/checkout', compact('subtotal', 'shipping', 'total'));
        break;

    case 'upload-payment':
        auth_required('buyer');
        $order_id = (int) ($_GET['id'] ?? $_POST['order_id'] ?? 0);
        $buyer = $_SESSION['user']['id'];
        $order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id=$order_id AND buyer_id=$buyer"));
        if (!$order)
            redirect('order-history');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $method = mysqli_real_escape_string($conn, $_POST['payment_method']);
            $proof = upload_file('proof', '/src/uploads/payments/', 'payment');
            mysqli_query($conn, "INSERT INTO payments(order_id,payment_method,proof,status) VALUES($order_id,'$method','$proof','Menunggu Konfirmasi')");
            mysqli_query($conn, "INSERT INTO notifications(user_id,message,is_read,created_at) VALUES($buyer,'Bukti pembayaran pesanan {$order['order_number']} berhasil diupload.',0,NOW())");
            $_SESSION['success'] = 'Bukti pembayaran terkirim. Tunggu konfirmasi admin.';
            redirect('tracking&id=' . $order_id);
        }
        view('buyer/upload-payment', compact('order'));
        break;

    case 'tracking':
        auth_required('buyer');
        $buyer = $_SESSION['user']['id'];
        $id = (int) ($_GET['id'] ?? 0);
        $order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id=$id AND buyer_id=$buyer"));
        view('buyer/tracking', compact('order'));
        break;

    case 'order-history':
        auth_required('buyer');
        $buyer = $_SESSION['user']['id'];
        $orders = mysqli_query($conn, "SELECT * FROM orders WHERE buyer_id=$buyer ORDER BY id DESC");
        view('buyer/order-history', compact('orders'));
        break;

    case 'review':
        auth_required('buyer');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pid = (int) $_POST['product_id'];
            $uid = $_SESSION['user']['id'];
            $rating = (int) $_POST['rating'];
            $comment = mysqli_real_escape_string($conn, $_POST['comment']);
            mysqli_query($conn, "INSERT INTO reviews(product_id,user_id,rating,comment) VALUES($pid,$uid,$rating,'$comment')");
            $_SESSION['success'] = 'Review berhasil dikirim.';
            redirect('product-detail&id=' . $pid);
        }
        redirect('products');
        break;

    case 'notifications':
        auth_required();
        $uid = $_SESSION['user']['id'];
        $notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id=$uid ORDER BY id DESC");
        mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE user_id=$uid");
        view('buyer/dashboard', compact('notifications'));
        break;

    case 'seller-dashboard':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $totalProducts = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM products WHERE seller_id=$sid"))[0];
        $totalOrders = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(DISTINCT oi.order_id) FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE p.seller_id=$sid"))[0];
        $totalSales = mysqli_fetch_row(mysqli_query($conn, "SELECT COALESCE(SUM(oi.quantity*oi.price),0) FROM order_items oi JOIN products p ON p.id=oi.product_id JOIN orders o ON o.id=oi.order_id WHERE p.seller_id=$sid AND o.status IN ('Pesanan Diterima','Selesai','Sedang Dikirim','Sedang Diproses','Pembayaran Dikonfirmasi')"))[0];
        view('seller/dashboard', compact('totalProducts', 'totalOrders', 'totalSales'));
        break;

    case 'seller-products':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $products = mysqli_query($conn, "SELECT p.*, c.name category FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE seller_id=$sid ORDER BY p.id DESC");
        view('seller/products', compact('products'));
        break;

    case 'seller-add-product':
        auth_required('seller');

        if (!seller_approved()) {
            $_SESSION['error'] = 'Akun seller belum diverifikasi admin.';
            redirect('seller-dashboard');
        }

        $categories = mysqli_query(
            $conn,
            "SELECT * FROM categories ORDER BY name"
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sid = (int) $_SESSION['user']['id'];
            $cat = (int) ($_POST['category_id'] ?? 0);

            $name = mysqli_real_escape_string(
                $conn,
                $_POST['name'] ?? ''
            );

            $weightSize = mysqli_real_escape_string(
                $conn,
                $_POST['weight_size'] ?? ''
            );

            $desc = mysqli_real_escape_string(
                $conn,
                $_POST['description'] ?? ''
            );

            $price = (float) ($_POST['price'] ?? 0);
            $stock = (int) ($_POST['stock'] ?? 0);

            $image = upload_file(
                'image',
                '/src/uploads/products/',
                'product',
                'default-product.png'
            );

            mysqli_query(
                $conn,
                "INSERT INTO products (
                seller_id,
                category_id,
                name,
                weight_size,
                description,
                price,
                stock,
                image
            ) VALUES (
                $sid,
                $cat,
                '$name',
                '$weightSize',
                '$desc',
                $price,
                $stock,
                '$image'
            )"
            );

            $_SESSION['success'] = 'Produk berhasil ditambahkan.';
            redirect('seller-products');
        }

        view('seller/add-product', compact('categories'));
        break;
    case 'seller-edit-product':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $id = (int) $_GET['id'];
        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id AND seller_id=$sid"));
        if (!$product)
            redirect('seller-products');
        $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cat = (int) $_POST['category_id'];
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $desc = mysqli_real_escape_string($conn, $_POST['description']);
            $price = (float) $_POST['price'];
            $stock = (int) $_POST['stock'];
            $image = $product['image'];
            $newImage = upload_file('image', '/src/uploads/products/', 'product');
            if ($newImage)
                $image = $newImage;
            mysqli_query($conn, "UPDATE products SET category_id=$cat,name='$name',description='$desc',price=$price,stock=$stock,image='$image' WHERE id=$id AND seller_id=$sid");
            redirect('seller-products');
        }
        view('seller/edit-product', compact('product', 'categories'));
        break;

    case 'seller-delete-product':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $id = (int) $_GET['id'];
        mysqli_query($conn, "DELETE FROM products WHERE id=$id AND seller_id=$sid");
        redirect('seller-products');
        break;

    case 'seller-orders':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $orders = mysqli_query($conn, "SELECT DISTINCT o.*, u.name buyer_name FROM orders o JOIN order_items oi ON oi.order_id=o.id JOIN products p ON p.id=oi.product_id JOIN users u ON u.id=o.buyer_id WHERE p.seller_id=$sid ORDER BY o.id DESC");
        view('seller/orders', compact('orders'));
        break;

    case 'seller-update-order':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        $id = (int) $_POST['order_id'];
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        mysqli_query($conn, "UPDATE orders o SET status='$status' WHERE id=$id AND EXISTS(SELECT 1 FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE oi.order_id=o.id AND p.seller_id=$sid)");
        redirect('seller-orders');
        break;

    case 'seller-stock':
        auth_required('seller');
        $sid = $_SESSION['user']['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) $_POST['product_id'];
            $stock = (int) $_POST['stock'];
            mysqli_query($conn, "UPDATE products SET stock=$stock WHERE id=$id AND seller_id=$sid");
        }
        $products = mysqli_query($conn, "SELECT * FROM products WHERE seller_id=$sid ORDER BY stock ASC");
        view('seller/stock', compact('products'));
        break;

    case 'admin-dashboard':
        auth_required('admin');
        $totalUser = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='buyer'"))[0];
        $totalSeller = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM users WHERE role='seller'"))[0];
        $totalProduct = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM products"))[0];
        $totalOrder = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM orders"))[0];
        view('admin/dashboard', compact('totalUser', 'totalSeller', 'totalProduct', 'totalOrder'));
        break;

    case 'admin-users':
        auth_required('admin');
        $users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
        view('admin/users', compact('users'));
        break;

    case 'admin-sellers':
        auth_required('admin');

        $sellers = mysqli_query(
            $conn,
            "SELECT *
         FROM users
         WHERE role='seller'
            OR seller_status='pending'
         ORDER BY id DESC"
        );

        view('admin/sellers', compact('sellers'));
        break;

    case 'admin-verify-seller':
        auth_required('admin');

        $id = (int) ($_GET['id'] ?? 0);

        mysqli_query(
            $conn,
            "UPDATE users
         SET role='seller',
             seller_status='approved'
         WHERE id=$id
           AND seller_status='pending'"
        );

        mysqli_query(
            $conn,
            "INSERT INTO notifications(
            user_id,
            message,
            is_read,
            created_at
         ) VALUES(
            $id,
            'Pendaftaran seller kamu telah disetujui admin. Silakan login ulang untuk membuka dashboard seller.',
            0,
            NOW()
         )"
        );

        $_SESSION['success'] = 'Seller berhasil diverifikasi.';
        redirect('admin-sellers');
        break;

    case 'admin-categories':
        auth_required('admin');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $desc = mysqli_real_escape_string($conn, $_POST['description']);
            mysqli_query($conn, "INSERT INTO categories(name,description) VALUES('$name','$desc')");
        }
        $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
        view('admin/categories', compact('categories'));
        break;

    case 'admin-products':
        auth_required('admin');
        $products = mysqli_query($conn, "SELECT p.*, c.name category, u.name seller_name FROM products p LEFT JOIN categories c ON c.id=p.category_id LEFT JOIN users u ON u.id=p.seller_id ORDER BY p.id DESC");
        view('admin/products', compact('products'));
        break;

    case 'admin-orders':
        auth_required('admin');
        $orders = mysqli_query($conn, "SELECT o.*, u.name buyer_name FROM orders o JOIN users u ON u.id=o.buyer_id ORDER BY o.id DESC");
        view('admin/orders', compact('orders'));
        break;

    case 'admin-payments':
        auth_required('admin');
        $payments = mysqli_query($conn, "SELECT pay.*, o.order_number, u.name buyer_name FROM payments pay JOIN orders o ON o.id=pay.order_id JOIN users u ON u.id=o.buyer_id ORDER BY pay.id DESC");
        view('admin/payments', compact('payments'));
        break;

    case 'admin-confirm-payment':
        auth_required('admin');
        $id = (int) $_GET['id'];
        $payment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT p.*, o.buyer_id, o.order_number FROM payments p JOIN orders o ON o.id=p.order_id WHERE p.id=$id"));
        if ($payment) {
            mysqli_query($conn, "UPDATE payments SET status='Dikonfirmasi' WHERE id=$id");
            mysqli_query($conn, "UPDATE orders SET status='Pembayaran Dikonfirmasi' WHERE id={$payment['order_id']}");
            mysqli_query($conn, "INSERT INTO notifications(user_id,message,is_read,created_at) VALUES({$payment['buyer_id']},'Pembayaran pesanan {$payment['order_number']} sudah dikonfirmasi.',0,NOW())");
        }
        redirect('admin-payments');
        break;

    case 'admin-reports':
        auth_required('admin');
        $income = mysqli_fetch_row(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status IN ('Pembayaran Dikonfirmasi','Sedang Diproses','Sedang Dikirim','Pesanan Diterima','Selesai')"))[0];
        $orders = mysqli_query($conn, "SELECT status, COUNT(*) total FROM orders GROUP BY status");
        view('admin/reports', compact('income', 'orders'));
        break;

    default:
        http_response_code(404);
        echo 'Halaman tidak ditemukan';
}
