<?php

session_start();
require '../conf/function.php';

if (!isset($_SESSION['user_id'])) {
    header("location: {$url}");
    exit(); 
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="E-Inventaris Dashboard" />
    <title>Dashboard - E-Inventaris</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="<?= $url ?>assets/img/logo-umsida.png" type="image/x-icon" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom-override.css" rel="stylesheet" />

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light">
        <!-- Brand -->
        <a class="navbar-brand ps-3" href="index.php">
            <img src="<?= $url ?>assets/img/logo-umsida.png" alt="Logo" style="height:32px;width:auto;margin-right:8px;vertical-align:middle;">
            E-Inventaris
        </a>
        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Spacer -->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <!-- User Dropdown -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-user" style="color:#fff;font-size:0.75rem;"></i>
                    </div>
                    <span class="d-none d-md-inline" style="font-size:0.85rem;font-weight:500;"><?= $_SESSION['username']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2" style="color:#ef4444;"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="sidebarOverlay"></div>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-gauge-high"></i></div>
                            Dashboard
                        </a>

                        <?php if ($_SESSION['role'] == 'admin') : ?>
                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsSoal" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                            Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsSoal" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="master_category.php">
                                    <i class="fas fa-tags me-2" style="font-size:0.75rem;opacity:0.5;"></i> Kategori
                                </a>
                                <a class="nav-link" href="master_barang.php">
                                    <i class="fas fa-box me-2" style="font-size:0.75rem;opacity:0.5;"></i> Barang
                                </a>
                                <a class="nav-link" href="master_supplier.php">
                                    <i class="fas fa-truck me-2" style="font-size:0.75rem;opacity:0.5;"></i> Supplier
                                </a>
                            </nav>
                        </div>
                        <?php endif; ?>

                        <div class="sb-sidenav-menu-heading">Transaksi</div>
                        <a class="nav-link" href="pembelian.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cart-plus"></i></div>
                            Pembelian
                        </a>
                        <a class="nav-link" href="pengeluaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-right-from-bracket"></i></div>
                            Pengeluaran
                        </a>
                        <a class="nav-link" href="return.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-rotate-left"></i></div>
                            Return
                        </a>

                        <div class="sb-sidenav-menu-heading">Laporan</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsNilai" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-lines"></i></div>
                            Laporan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsNilai" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="laporan_pembelian.php">
                                    <i class="fas fa-receipt me-2" style="font-size:0.75rem;opacity:0.5;"></i> Pembelian
                                </a>
                                <a class="nav-link" href="laporan_aset_keluar.php">
                                    <i class="fas fa-file-export me-2" style="font-size:0.75rem;opacity:0.5;"></i> Pengeluaran
                                </a>
                                <a class="nav-link" href="laporan_return.php">
                                    <i class="fas fa-file-circle-check me-2" style="font-size:0.75rem;opacity:0.5;"></i> Retur
                                </a>
                                <a class="nav-link" href="laporan_inventaris_tersedia.php">
                                    <i class="fas fa-warehouse me-2" style="font-size:0.75rem;opacity:0.5;"></i> Stock Inventaris
                                </a>
                            </nav>
                        </div>

                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <div class="sb-sidenav-menu-heading">Pengaturan</div>
                            <a class="nav-link" href="akun_pengguna.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-gear"></i></div>
                                Akun Pengguna
                            </a>
                        <?php endif; ?>
                        
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai</div>
                    <div class="text-uppercase" style="font-weight:600;"><?= $_SESSION['username']; ?></div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">