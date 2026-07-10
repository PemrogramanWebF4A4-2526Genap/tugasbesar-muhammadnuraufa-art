<?php
class AuthController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = mysqli_real_escape_string($this->conn, $_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $q = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
            $user = mysqli_fetch_assoc($q);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;

                if ($user['role'] === 'admin') {
                    redirect('admin-dashboard');
                }

                if ($user['role'] === 'seller') {
                    redirect('seller-dashboard');
                }

                redirect('home');
            }

            $error = 'Email atau password salah.';
        }

        view('public/login', compact('error'));
    }

    public function register($role = 'buyer')
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = mysqli_real_escape_string($this->conn, $_POST['name'] ?? '');
            $email = mysqli_real_escape_string($this->conn, $_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $seller_status = $role === 'seller' ? 'pending' : 'approved';

            $cek = mysqli_query($this->conn, "SELECT id FROM users WHERE email='$email'");

            if (mysqli_num_rows($cek) > 0) {
                $error = 'Email sudah terdaftar.';
            } else {
                mysqli_query($this->conn, "
                    INSERT INTO users(name, email, password, role, seller_status, created_at) 
                    VALUES('$name', '$email', '$hash', '$role', '$seller_status', NOW())
                ");

                $_SESSION['success'] = $role === 'seller'
                    ? 'Register seller berhasil. Tunggu verifikasi admin.'
                    : 'Register berhasil. Silakan login.';

                redirect('login');
            }
        }

        $viewName = $role === 'seller' ? 'public/register-seller' : 'public/register';
        view($viewName, compact('error'));
    }
    public function forgotPassword()
    {
        $error = null;
        $resetLink = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = mysqli_real_escape_string(
                $this->conn,
                $_POST['email'] ?? ''
            );

            $q = mysqli_query(
                $this->conn,
                "SELECT * FROM users WHERE email='$email' LIMIT 1"
            );

            $user = mysqli_fetch_assoc($q);

            if (!$user) {
                $error = 'Email tidak ditemukan.';
            } elseif ($user['role'] === 'admin') {
                $error = 'Reset password admin tidak bisa dilakukan melalui halaman ini.';
            } else {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

                mysqli_query(
                    $this->conn,
                    "DELETE FROM password_resets WHERE email='$email'"
                );

                mysqli_query(
                    $this->conn,
                    "INSERT INTO password_resets(email, token, expires_at, created_at)
                 VALUES('$email', '$token', '$expires', NOW())"
                );

                $resetLink = 'http://localhost/freshmart-online/index.php?page=reset-password&token=' . urlencode($token);
            }
        }

        view('public/forgot-password', compact('error', 'resetLink'), false);
    }
    public function resetPassword()
    {
        $error = null;
        $success = null;
        $token = $_GET['token'] ?? $_POST['token'] ?? '';

        $tokenSafe = mysqli_real_escape_string($this->conn, $token);

        $q = mysqli_query(
            $this->conn,
            "SELECT * FROM password_resets
     WHERE token='$tokenSafe'
     LIMIT 1"
        );

        $reset = mysqli_fetch_assoc($q);

        if (!$reset) {
            $error = 'Link reset password tidak valid atau sudah expired.';
            view('public/reset-password', compact('error', 'success', 'token'), false);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Konfirmasi password tidak sama.';
            } else {
                $email = mysqli_real_escape_string($this->conn, $reset['email']);
                $hash = password_hash($password, PASSWORD_DEFAULT);

                mysqli_query(
                    $this->conn,
                    "UPDATE users SET password='$hash' WHERE email='$email'"
                );

                mysqli_query(
                    $this->conn,
                    "DELETE FROM password_resets WHERE email='$email'"
                );

                $success = 'Password berhasil diubah. Silakan login.';
            }
        }

        view('public/reset-password', compact('error', 'success', 'token'), false);
    }
    public function logout()
    {
        session_destroy();
        redirect('home');
    }
}
?>