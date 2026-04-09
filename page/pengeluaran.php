<?php include "src/header.php" ?>

<?php 


if (isset($_POST['posting'])) {
    $product = $_POST['product'];
    $date = date('Y-m-d\TH:i', strtotime($_POST['date']));
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    if (empty($product) || empty($date) || empty($qty) || empty($keterangan)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = inputSales($product, $_SESSION['user_id'], $qty, $keterangan, $date);
        
            if ($response['status']) {
                $msg = $response['message'];
                echo "<script>
                    alert('{$msg}');
                    window.history.back(); 
                </script>";
            } else {
                throw new Exception("Data gagal ditambahkan.");
            }
        } catch (Exception $e) {
            echo "<script>
                alert('Gagal menambahkan data: {$e->getMessage()}. Hubungi administrator');
                window.history.back(); 
            </script>";
        }
    }
}

?>

<main>
    <div class="container-fluid px-4">

        <!-- Button Modal History Pengeluaran -->
        <button type="button" class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#history">
            <i class="fas fa-list-ul me-2"></i> History Pengeluaran
        </button>

        <!-- Card: Form Pengeluaran -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Form Pengeluaran
            </div>
            <div class="card-body">
                <form method="POST">
                    
                    <div class="row g-3">
                        <!-- Input: Nama Produk -->
                        <div class="col-md-12">
                            <label for="product" class="form-label">Nama Produk</label>
                            <select name="product" class="form-control" id="product" required>
                                <option value="">Pilih Produk</option>
                                <?php
                                $products = getMasterBarang();
                                foreach ($products as $product) {
                                    echo "<option value='{$product['id']}'>{$product['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Input: Tanggal -->
                        <div class="col-md-6 col-6">
                            <label for="dateInput" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="dateInput" name="date">
                        </div>

                        <!-- Input: QTY -->
                        <div class="col-md-6 col-6">
                            <label for="qty" class="form-label">QTY</label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="Masukkan QTY">
                        </div>

                        <!-- Input: Keterangan -->
                        <div class="col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                        </div>

                        <!-- Button: Posting -->
                        <div class="col-12">
                            <button name="posting" type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin posting?')">
                                <i class="fas fa-upload me-2"></i> Posting
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card: Tabel Data Barang -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Barang
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $barang = getMasterBarang();
                        $no = 1;
                        foreach ($barang as $item) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>PRODUCT-{$item['id']}</td>
                                    <td>{$item['name']}</td>
                                    <td>{$item['stock']}</td>
                                </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>







<div class="modal fade" id="history" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">History Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Quantity</th>
                                <th>Info</th>
                                <th>Sale Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = getSalesHistory() ?>
                            <?php renderSalesTable($result); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php include "src/footer.php" ?>