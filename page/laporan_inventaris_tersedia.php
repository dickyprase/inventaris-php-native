<?php include "src/header.php" ?>
<?php $data = getDashboardData() ?>

<main>
    <div class="container-fluid px-4">
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Laporan Stock
            </div>
            <div class="card-body">
            
            <form method="POST" action="report_stock.php" class="row g-3">
                <div class="col-md-4 align-self-end">
                    <button name="export" type="submit" class="btn btn-primary">Export to Excel</button>
                </div>
            </form>

<hr>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = getStock() ?>
                            <?php renderStockTable($result); ?>
                        </tbody>
                    </table>
            </div>
        </div>


        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Rekap Stock
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <!-- Total Produk -->
                    <div class="card-body text-center" style="font-size: 20px; width: 45%;">
                        <p>Total Produk:</p>
                        <p><strong><?= $data['total_products'] ?> Barang</strong></p>
                    </div>
                    
                    <!-- Total Aset -->
                    <div class="card-body text-center" style="font-size: 20px; width: 45%;">
                        <p>Total Aset:</p>
                        <p><strong>Rp. <?= number_format($data['total_assets']) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>



    </div>
</main>





<?php
include "src/footer.php";
?>