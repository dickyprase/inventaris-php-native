<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Inventaris - Sistem Manajemen Inventaris Modern untuk mengelola data barang dengan akurat dan efisien.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styleDashboard.css">
    <link rel="icon" href="assets/img/logo-umsida.png" type="image/x-icon">
    <title>E-Inventaris — Sistem Manajemen Inventaris</title>
</head>
<body>

    <!-- Navbar -->
    <nav class="landing-nav" id="landingNav">
        <a href="#" class="nav-brand">
            <img src="assets/img/logo-umsida.png" alt="Logo UMSIDA">
            <span>E-Inventaris</span>
        </a>
        <a href="login.php" class="btn-login">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Masuk
        </a>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg-grid"></div>
        <div class="hero-glow hero-glow-1"></div>
        <div class="hero-glow hero-glow-2"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                Sistem Inventaris Digital
            </div>
            <h1 class="hero-title">
                Kelola Inventaris<br>
                <span class="gradient-text">Lebih Cerdas & Efisien</span>
            </h1>
            <p class="hero-subtitle">
                Platform manajemen inventaris modern yang dirancang untuk membantu Anda mengelola data barang, pembelian, dan aset dengan antarmuka yang bersih dan intuitif.
            </p>
            <div class="hero-actions">
                <a href="login.php" class="btn-hero-primary">
                    <i class="fas fa-arrow-right"></i>
                    Mulai Sekarang
                </a>
                <a href="#features" class="btn-hero-secondary">
                    <i class="fas fa-info-circle"></i>
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section fade-in-section" id="features">
        <div class="section-header">
            <p class="section-label">Fitur Unggulan</p>
            <h2 class="section-title">Semua yang Anda Butuhkan</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon blue">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <h3 class="feature-title">Manajemen Stok</h3>
                <p class="feature-desc">Pantau stok barang secara real-time dengan data yang selalu akurat dan terkini.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple">
                    <i class="fas fa-cart-shopping"></i>
                </div>
                <h3 class="feature-title">Pencatatan Pembelian</h3>
                <p class="feature-desc">Catat setiap transaksi pembelian beserta detail faktur dan supplier dengan mudah.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon cyan">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Laporan & Analitik</h3>
                <p class="feature-desc">Dapatkan insight mendalam melalui laporan visual yang informatif dan dapat diunduh.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon emerald">
                    <i class="fas fa-rotate-left"></i>
                </div>
                <h3 class="feature-title">Manajemen Return</h3>
                <p class="feature-desc">Kelola proses return barang dengan pelacakan status yang terorganisir.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <p>© <?= date("Y") ?> E-Inventaris — Universitas Muhammadiyah Sidoarjo</p>
    </footer>

    <script>
        // Navbar scroll effect
        const nav = document.getElementById('landingNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Fade-in sections on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.fade-in-section').forEach(el => observer.observe(el));
    </script>
</body>
</html>