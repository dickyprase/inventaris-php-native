<?php 

require "conf/function.php";

session_start();

if (isset($_SESSION['user_id'])) {
    header("location:{$url}page/");
    exit();
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = login($username, $password);

    if ($result['status']) {
        header("Location: {$url}/page");
        exit();
    } else {
        $error_message = $result['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
    <link rel="icon" href="assets/img/logo-umsida.png" type="image/x-icon">
    <title>Login | E-Inventaris</title>
</head>
<body>

    <!-- Left Art Panel -->
    <div class="login-art">
        <div class="art-glow"></div>
        <div class="art-glow art-glow-2"></div>
        <div class="art-content">
            <div class="art-icon">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <h2>E-Inventaris</h2>
            <p>Kelola inventaris Anda dengan mudah, cepat, dan terorganisir dalam satu platform.</p>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="login-form-panel">
        <div class="login-card">
            <div class="logo-section">
                <img src="assets/img/logo-umsida.png" alt="Logo UMSIDA">
                <h1>Selamat Datang</h1>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="alert-error">
                    <i class="fas fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input type="text" class="form-input" name="username" placeholder="Masukkan username" required autocomplete="username">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-input" name="password" id="passwordInput" placeholder="Masukkan password" required autocomplete="current-password">
                        <i class="fas fa-lock"></i>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-submit" name="login">
                    Masuk
                </button>
                <div class="login-footer">
                    <a href="<?= $url ?>">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>