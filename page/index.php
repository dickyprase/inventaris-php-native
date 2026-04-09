<?php include "src/header.php" ?>
<?php $data = getDashboardData(); ?>

<main>
    <div class="container-fluid px-4">
        <!-- Welcome Banner -->
        <div class="welcome-banner mt-4">
            <h2>👋 Selamat Datang, <?= ucfirst($_SESSION['username']) ?>!</h2>
            <p>Berikut ringkasan inventaris Anda hari ini.</p>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-break"><?= $data['total_products'] ?></h3>
                        <p>Jumlah Barang</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="stat-icon emerald">
                        <i class="fas fa-cart-shopping"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-break"><?= $data['total_purchases'] ?></h3>
                        <p>Total Pembelian</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="stat-icon amber">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-break"><?= $data['total_sales'] ?></h3>
                        <p>Aset Keluar</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-12">
                <div class="stat-card">
                    <div class="stat-icon rose">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="stat-info">
                        <h3 class="text-break">Rp.<?= number_format($data['total_assets']) ?></h3>
                        <p>Total Aset</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card chart-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Grafik Pembelian
                    </div>
                    <div class="card-body">
                        <canvas id="purchasesChart" width="100%" height="30"></canvas>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-clock me-1"></i> Diperbarui terakhir
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card chart-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area"></i>
                        Grafik Aset Keluar
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="100%" height="30"></canvas>
                    </div>
                    <div class="card-footer">
                        <i class="fas fa-clock me-1"></i> Diperbarui terakhir
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
     fetch('get_chart_data.php')
            .then(response => response.json())
            .then(data => {
                const chartDefaults = {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: { 
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)' }
                        },
                        y: { 
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.04)' }
                        }
                    },
                    elements: {
                        line: { tension: 0.4 },
                        point: { radius: 3, hoverRadius: 6 }
                    }
                };

                // Purchases Chart
                var ctx1 = document.getElementById("purchasesChart").getContext("2d");
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: data.days.map(day => 'Hari ' + day),
                        datasets: [{
                            label: "Pembelian",
                            backgroundColor: "rgba(99, 102, 241, 0.1)",
                            borderColor: "#4f46e5",
                            borderWidth: 2,
                            data: data.purchases,
                            fill: true,
                            pointBackgroundColor: "#4f46e5"
                        }]
                    },
                    options: chartDefaults
                });

                // Sales Chart
                var ctx2 = document.getElementById("salesChart").getContext("2d");
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: data.days.map(day => 'Hari ' + day),
                        datasets: [{
                            label: "Aset Keluar",
                            backgroundColor: "rgba(244, 63, 94, 0.1)",
                            borderColor: "#e11d48",
                            borderWidth: 2,
                            data: data.sales,
                            fill: true,
                            pointBackgroundColor: "#e11d48"
                        }]
                    },
                    options: chartDefaults
                });
            })
            .catch(error => console.error('Error:', error));
</script>
<?php include "src/footer.php" ?>