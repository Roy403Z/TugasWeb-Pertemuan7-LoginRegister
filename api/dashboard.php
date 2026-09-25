<?php
// Proteksi halaman dashboard via Cookie
if (!isset($_COOKIE['user_login_data'])) {
    header('Location: login.php');
    exit();
}

$user = json_decode($_COOKIE['user_login_data'], true);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dashboard Berhasil Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark text-white min-vh-100 d-flex flex-column py-5" style="background-color: #0f172a !important;">

    <div class="container my-auto" style="max-width: 650px;">
        <div class="card border-0 shadow-lg p-4 p-sm-5 text-center text-white" style="background-color: #1e293b !important; border-radius: 16px;">
            <div class="mb-3">
                <i class="bi bi-patch-check-fill display-1 text-success"></i>
            </div>
            
            <h1 class="fw-bold text-info mb-2">Hore, Kamu Berhasil Login! 🎉</h1>
            <p class="text-light lead mb-4">Selamat datang kembali, <strong><?= htmlspecialchars($user['name']); ?></strong>!</p>

            <div class="alert alert-success bg-dark border-success text-success p-3 rounded mb-4 text-start">
                <i class="bi bi-shield-check me-2"></i><strong>Status Otentikasi:</strong> Akses akun kamu aktif dan terverifikasi di Supabase Cloud.
            </div>

            <div class="card bg-dark border-0 p-4 text-start mb-4">
                <h6 class="text-secondary text-uppercase fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Detail Rincian Akun:</h6>
                <div class="row g-2">
                    <div class="col-4 text-secondary">Nama:</div>
                    <div class="col-8 fw-bold text-white"><?= htmlspecialchars($user['name']); ?></div>
                    <div class="col-4 text-secondary">Email:</div>
                    <div class="col-8 text-white"><?= htmlspecialchars($user['email']); ?></div>
                    <div class="col-4 text-secondary">UUID User:</div>
                    <div class="col-8 text-warning font-monospace small"><?= htmlspecialchars($user['id']); ?></div>
                </div>
            </div>

            <div class="d-grid gap-2 col-sm-8 mx-auto">
                <a href="logout.php" class="btn btn-outline-danger btn-lg fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Keluar / Logout</a>
            </div>
        </div>
    </div>

    <footer class="text-center text-secondary mt-auto pt-4 small">
        <p>&copy; 2026 Ade Roy Simbolon. Tugas Rutin 7 Pemrograman Web UNIMED.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
