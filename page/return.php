<?php
include "src/header.php";


if (isset($_POST['posting'])) {
    $return_type = $_POST['return_type'];
    $type_id = $_POST['type_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $reason = $_POST['reason'];
    $return_date = $_POST['return_date'];

    if (empty($return_date) || empty($return_type) || empty($type_id) || empty($product_id) || empty($quantity) || empty($reason)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = processReturn($product_id, $_SESSION['user_id'], $quantity, $reason, $return_date, $return_type, $type_id);
        
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
                alert('Gagal return data: {$e->getMessage()}. Hubungi administrator');
                window.history.back(); 
            </script>";
        }
    }
}


?>
<main>
    <div class="container-fluid px-4">
        <!-- Button Modal History Pembelian -->
        <button type="button" class="btn btn-success mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#history">
            <i class="fas fa-clock-rotate-left"></i>
            History Retur
        </button>

        <!-- Modal History Retur Pembelian -->

        <!-- Tabel Data Retur Pembelian -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Form Return
            </div>
            <div class="card-body">
            <form action="" method="POST">
            <!-- Pilihan Return Type -->
            <div class="mb-3">
                <label for="return_type" class="form-label">Return Type:</label>
                <select id="return_type" name="return_type" class="form-select" required>
                    <option value="">-- Pilih Jenis Pengembalian --</option>
                    <option value="purchase">Pembelian</option>
                    <option value="sale">Pengeluaran</option>
                </select>
            </div>

            <!-- Pilihan Referensi ID -->
            <div class="mb-3">
                <label for="type_id" class="form-label">Reference ID:</label>
                <select id="type_id" name="type_id" class="form-select" required>
                    <option value="">-- Pilih Return Type Dulu --</option>
                </select>
            </div>

            <!-- Pilihan Produk -->
            <div class="mb-3">
                <label for="product_id" class="form-label">Product:</label>
                <select id="product_id" name="product_id" class="form-select" required>
                    <option value="">-- Pilih Reference ID Dulu --</option>
                </select>
            </div>

            <!-- Input Quantity -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>

            <!-- Input Reason -->
            <div class="mb-3">
                <label for="reason" class="form-label">Reason:</label>
                <textarea id="reason" name="reason" class="form-control" required></textarea>
            </div>

            <!-- Input Return Date -->
            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date:</label>
                <input type="date" id="return_date" name="return_date" class="form-control" required>
            </div>

            <button type="submit" name="posting" class="btn btn-primary">Submit</button>
        </form>

                <!-- Tabel Data Barang -->
                <div class="card mb-4 mt-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Barang
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                <th>No</th>
                                    <th>Product Id</th>
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
        </div>
    </div>
</main>


<div class="modal fade" id="history" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Return History</h5>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
        $(document).ready(function() {
            // Ketika return_type berubah
            $('#return_type').change(function() {
                let returnType = $(this).val();
                $('#type_id').html('<option value="">-- Loading --</option>');
                $('#product_id').html('<option value="">-- Pilih Reference ID Dulu --</option>');

                if (returnType) {
                    // Ambil data referensi ID
                    $.ajax({
                        url: 'get_references.php',
                        method: 'POST',
                        data: { return_type: returnType },
                        success: function(data) {
                            $('#type_id').html(data);
                        }
                    });
                } else {
                    $('#type_id').html('<option value="">-- Pilih Return Type Dulu --</option>');
                }
            });

            // Ketika type_id berubah
            $('#type_id').change(function() {
                let typeId = $(this).val();
                let returnType = $('#return_type').val();
                $('#product_id').html('<option value="">-- Loading --</option>');

                if (typeId) {
                    // Ambil data produk terkait
                    $.ajax({
                        url: 'get_products.php',
                        method: 'POST',
                        data: { type_id: typeId, return_type: returnType },
                        success: function(data) {
                            $('#product_id').html(data);
                        }
                    });
                } else {
                    $('#product_id').html('<option value="">-- Pilih Reference ID Dulu --</option>');
                }
            });
        });
    </script>

<?php
include "src/footer.php";
?>