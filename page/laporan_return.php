<?php
include "src/header.php";

?>
<main>
    <div class="container-fluid px-4">
        <div class="card mb-4 mt-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Laporan Return
            </div>
            <div class="card-body">
            
            <form method="POST" action="report_return.php" class="row g-3">
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
                                <th>Return Type</th>
                                <th>Transaction ID</th>
                                <th>Quantity</th>
                                <th>Info</th>
                                <th>Return Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = getReturnHistory() ?>
                            <?php renderReturnTable($result); ?>
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="history" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container mt-5">
            <h2 class="text-center mb-4">Return History</h2>
            <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>User</th>
                        <th>Return Type</th>
                        <th>Transaction ID</th>
                        <th>Quantity</th>
                        <th>Info</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result = getReturnHistory() ?>
                    <?php renderReturnTable($result); ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>



<?php
include "src/footer.php";
?>