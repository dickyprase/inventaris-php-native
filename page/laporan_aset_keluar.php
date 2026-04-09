<?php
include "src/header.php";

?>
<main>
    <div class="container-fluid px-4">
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Laporan Pengeluaran
            </div>
            <div class="card-body">
            
            <form method="POST" action="report_pengeluaran.php" class="row g-3">
                <div class="col-md-4">
                    <label for="from" class="form-label">Dari Tanggal</label>
                    <input type="date" id="from" name="from" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="to" class="form-label">Sampai Tanggal</label>
                    <input type="date" id="to" name="to" class="form-control" required>
                </div>
                <div class="col-md-4 align-self-end">
                    <button name="export" type="submit" class="btn btn-primary">Export to Excel</button>
                </div>
            </form>

            <br><br><hr><br>

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Quantity</th>
                                <th>Keterangan</th>
                                <th>Tanggal Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = getSalesHistory() ?>
                            <?php renderSalesTable($result); ?>
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
</main>





<?php
include "src/footer.php";
?>