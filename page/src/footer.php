<footer class="py-4 mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div>&copy; E-Inventaris <?= date("Y") ?> — Universitas Muhammadiyah Sidoarjo</div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<!-- Bottom Navigation (Mobile Only) -->
<nav class="bottom-nav">
    <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="pembelian.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'pembelian.php' ? 'active' : ''; ?>">
        <i class="fas fa-cart-plus"></i>
        <span>Beli</span>
    </a>
    <a href="pengeluaran.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'pengeluaran.php' ? 'active' : ''; ?>">
        <i class="fas fa-arrow-right-from-bracket"></i>
        <span>Keluar</span>
    </a>
    <a href="#" class="nav-item" data-bs-toggle="modal" data-bs-target="#mobileMenuModal">
        <i class="fas fa-bars"></i>
        <span>Menu</span>
    </a>
</nav>

<!-- Mobile Menu Modal -->
<div class="modal fade" id="mobileMenuModal" tabindex="-1" aria-labelledby="mobileMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mobileMenuModalLabel">Menu Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group list-group-flush">
                    <!-- Transaksi -->
                    <div class="list-group-item bg-light fw-bold text-uppercase small mt-2">Transaksi Lainnya</div>
                    <a href="return.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-rotate-left me-2 text-primary"></i> Return Barang
                    </a>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                    <!-- Master Data -->
                    <div class="list-group-item bg-light fw-bold text-uppercase small mt-2">Master Data</div>
                    <a href="master_category.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2 text-primary"></i> Kategori
                    </a>
                    <a href="master_barang.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2 text-primary"></i> Barang
                    </a>
                    <a href="master_supplier.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-truck me-2 text-primary"></i> Supplier
                    </a>
                    <?php endif; ?>

                    <!-- Laporan -->
                    <div class="list-group-item bg-light fw-bold text-uppercase small mt-2">Laporan</div>
                    <a href="laporan_pembelian.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-receipt me-2 text-primary"></i> Laporan Pembelian
                    </a>
                    <a href="laporan_aset_keluar.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-export me-2 text-primary"></i> Laporan Pengeluaran
                    </a>
                    <a href="laporan_return.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-circle-check me-2 text-primary"></i> Laporan Retur
                    </a>
                    <a href="laporan_inventaris_tersedia.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-warehouse me-2 text-primary"></i> Stock Inventaris
                    </a>

                    <!-- Pengaturan -->
                    <div class="list-group-item bg-light fw-bold text-uppercase small mt-2">Akun</div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                    <a href="akun_pengguna.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-users-gear me-2 text-primary"></i> Kelola Pengguna
                    </a>
                    <?php endif; ?>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>