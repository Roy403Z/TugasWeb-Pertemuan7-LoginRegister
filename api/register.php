<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_login'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'));
    $email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Semua bidang wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        $check_user = supabase_request("users?email=eq." . urlencode($email));

        if (!empty($check_user) && !isset($check_user['error'])) {
            $error = 'Email sudah terdaftar! Gunakan email lain.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $new_user = [
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ];

            $result = supabase_request('users', 'POST', $new_user);

            if ($result && !isset($result['error'])) {
                $success = 'Registrasi berhasil! Silakan <a href="login.php" class="alert-link">Login ke akun Anda</a>.';
            } else {
                $error = 'Gagal menyimpan data ke Supabase.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Supabase Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-white min-vh-100 d-flex flex-column py-5" style="background-color: #0f172a !important;">
    <div class="container my-auto" style="max-width: 480px;">
        <div class="card bg-secondary text-white border-0 shadow-lg p-4 p-sm-5" style="background-color: #1e293b !important;">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill display-4 text-info"></i>
                <h2 class="fw-bold mt-2">Buat Akun Baru</h2>
            </div>

            <?php if ($error): ?><div class="alert alert-danger"><?= $error; ?></div><?php endif; ?>
            <?php if ($success): ?><div class="alert alert-success"><?= $success; ?></div><?php endif; ?>

            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control bg-dark text-white border-0" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-0" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-0" placeholder="Minimal 6 karakter" required>
                </div>
                <button type="submit" class="btn btn-info btn-lg w-100 fw-bold text-dark shadow-sm">Daftar Sekarang</button>
            </form>
            <div class="text-center mt-4 pt-3 border-top border-dark">
                <p class="small text-light mb-0">Sudah punya akun? <a href="login.php" class="text-info fw-bold">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>