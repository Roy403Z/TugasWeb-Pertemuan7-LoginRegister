<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_login'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email dan Password wajib diisi!';
    } else {
        $user_data = supabase_request("users?email=eq." . urlencode($email));

        if (!empty($user_data) && isset($user_data[0]) && !isset($user_data['error'])) {
            $user = $user_data[0];

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_login'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];

                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Password yang Anda masukkan salah!';
            }
        } else {
            $error = 'Email tidak terdaftar!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System - Supabase Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-white min-vh-100 d-flex flex-column py-5" style="background-color: #0f172a !important;">
    <div class="container my-auto" style="max-width: 440px;">
        <div class="card bg-secondary text-white border-0 shadow-lg p-4 p-sm-5" style="background-color: #1e293b !important;">
            <div class="text-center mb-4">
                <i class="bi bi-shield-lock-fill display-4 text-info"></i>
                <h2 class="fw-bold mt-2">Selamat Datang</h2>
            </div>

            <?php if ($error): ?><div class="alert alert-danger"><?= $error; ?></div><?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-0" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-0" required>
                </div>
                <button type="submit" class="btn btn-info btn-lg w-100 fw-bold text-dark shadow-sm">Login Akun</button>
            </form>
            <div class="text-center mt-4 pt-3 border-top border-dark">
                <p class="small text-light mb-0">Belum memiliki akun? <a href="register.php" class="text-info fw-bold">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>