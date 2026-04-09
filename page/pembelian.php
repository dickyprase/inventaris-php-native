<?php include "src/header.php" ?>


<main>
    <div class="container-fluid px-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#history">
            <i class="fas fa-list-ul me-2"></i>
            History Pembelian
        </button>

        <!-- Modal History Pembelian -->
        <div class="modal fade" id="history" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="historyModalLabel">History Pembelian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faktur</th>
                                        <th>Supplier</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = getPurchaseHistory();
                                    $no = 1;
                                    foreach ($result as $purchase) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $purchase['faktur'] ?></td>
                                            <td><?= $purchase['supplier_name'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($purchase['purchase_date'])) ?></td>
                                            <td>Rp <?= number_format($purchase['total'], 0, ',', '.') ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm" type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#detail<?= $purchase['id'] ?>" 
                                                        aria-expanded="false" 
                                                        aria-controls="detail<?= $purchase['id'] ?>">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="p-0">
                                                <div class="collapse" id="detail<?= $purchase['id'] ?>">
                                                    <div class="card card-body m-2">
                                                        <table class="table table-bordered table-striped mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Produk</th>
                                                                    <th>Quantity</th>
                                                                    <th>Harga</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $details = getPurchaseDetails($purchase['id']);
                                                                foreach ($details as $detail) {
                                                                    echo "<tr>
                                                                            <td>{$detail['product_name']}</td>
                                                                            <td>{$detail['quantity']}</td>
                                                                            <td>Rp " . number_format($detail['price'], 0, ',', '.') . "</td>
                                                                            <td>Rp " . number_format($detail['total'], 0, ',', '.') . "</td>
                                                                        </tr>";
                                                                }
                                                                ?>
                                                                <tr class="table-info">
                                                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                                    <td><strong>Rp <?= number_format($purchase['total'], 0, ',', '.') ?></strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
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

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Form Pembelian
            </div>
            <div class="card-body">
                <form id="purchaseForm">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-6">
                            <label for="faktur" class="form-label">Faktur</label>
                            <input type="text" name="faktur" class="form-control" id="faktur" required>
                        </div>
                        <div class="col-md-6 col-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" name="date" class="form-control" id="date" required>
                        </div>
                        <div class="col-md-12">
                            <label for="supplier" class="form-label">Supplier</label>
                            <select name="supplier" class="form-control" id="supplier" required>
                                <option value="">Pilih Supplier</option>
                                <?php
                                $suppliers = getSuppliers();
                                foreach ($suppliers as $supplier) {
                                    echo "<option value='{$supplier['id']}'>{$supplier['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">Pilih Barang</div>
                    <div class="card-body">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $barang = getMasterBarang();
                                $no = 1;
                                foreach ($barang as $item) {
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$item['name']}</td>
                                            <td>{$item['stock']}</td>
                                            <td>{$item['price']}</td>
                                            <td>
                                                <button class='btn btn-primary btn-sm add-to-cart' 
                                                    data-id='{$item['id']}' 
                                                    data-name='{$item['name']}' 
                                                    data-price='{$item['price']}' 
                                                    data-stock='{$item['stock']}'>
                                                    Tambah
                                                </button>
                                            </td>
                                        </tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Cart</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="cartTable">
                                <!-- Cart items will be added dynamically -->
                            </tbody>
                        </table>
                        <button class="btn btn-success mt-4" id="submitCart">Simpan Pembelian</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function showDetail(purchaseId) {
  // Load detail data using AJAX
  $.ajax({
    url: 'get_purchase_detail.php',
    type: 'POST',
    data: {purchase_id: purchaseId},
    success: function(response) {
      $('#detailContent').html(response);
      $('#detailModal').modal('show');
    }
  });
}
</script>

<script>
let cart = []; // Array untuk menyimpan data cart

// Event listener untuk tombol Tambah
$(document).on('click', '.add-to-cart', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = parseFloat($(this).data('price'));
        const stock = parseInt($(this).data('stock'));

        // Cek apakah produk sudah ada di cart
        const existingProduct = cart.find(item => item.id === id);
        if (existingProduct) {
            existingProduct.quantity += 1; // Tambah jumlah jika sudah ada
        } else {
            cart.push({ id, name, price, stock, quantity: 1 }); // Tambahkan produk baru ke cart
        }

        updateCartTable(); // Perbarui tabel cart
    });

// Fungsi untuk menambah item ke cart
function addToCart(id, name, price, stock) {
    const existingProduct = cart.find(item => item.id === id);
    if (existingProduct) {
        // Jika harga berbeda, konfirmasi update
        if (existingProduct.price !== price) {
            Swal.fire({
                title: 'Harga Berbeda',
                text: `Harga sebelumnya: ${existingProduct.price}. Update ke harga baru: ${price}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Update',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    existingProduct.price = price;
                    existingProduct.quantity += 1;
                    updateCartTable();
                }
            });
        } else {
            existingProduct.quantity += 1;
            updateCartTable();
        }
    } else {
        cart.push({ id, name, price, stock, quantity: 1 });
        updateCartTable();
    }
}

// Event listener untuk mengubah harga
$(document).on('click', '.edit-price', function() {
    const index = $(this).data('index');
    const item = cart[index];
    
    Swal.fire({
        title: 'Update Harga',
        input: 'number',
        inputLabel: `Harga baru untuk ${item.name}`,
        inputValue: item.price,
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value || value <= 0) {
                return 'Harga harus lebih dari 0!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            cart[index].price = parseFloat(result.value);
            updateCartTable();
        }
    });
});

// Fungsi untuk memperbarui tabel cart
function updateCartTable() {
    const cartTable = $('#cartTable');
    cartTable.empty();
    let total = 0;
    
    cart.forEach((item, index) => {
        const rowTotal = item.quantity * item.price;
        total += rowTotal;
        cartTable.append(`
            <tr>
                <td>${item.name}</td>
                <td>
                    ${item.price.toFixed(2)}
                    <button class="btn btn-warning btn-sm edit-price ms-2" data-index="${index}">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
                <td>
                    <input type="number" class="form-control quantity" 
                        data-index="${index}" value="${item.quantity}" 
                        min="1" >
                </td>
                <td>${rowTotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
    });
    
    cartTable.append(`
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td><strong>${total.toFixed(2)}</strong></td>
            <td></td>
        </tr>
    `);

    // Tambahkan event listener ke input quantity
    $('.quantity').on('change', function () {
        const index = $(this).data('index'); // Ambil index dari atribut data-index
        const newQuantity = parseInt($(this).val()); // Ambil nilai baru dari input
        if (newQuantity > 0) { // Validasi agar quantity tidak negatif
            cart[index].quantity = newQuantity; // Update quantity di array cart
            updateCartTable(); // Refresh tabel
        }
    });

}


// Event listener untuk menghapus item dari cart
$(document).on('click', '.remove-from-cart', function() {
    const index = $(this).data('index');
    const item = cart[index];
    
    Swal.fire({
        title: 'Hapus Item',
        text: `Hapus ${item.name} dari cart?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            cart.splice(index, 1);
            updateCartTable();
        }
    });
});


// Event listener untuk submit cart
$('#submitCart').on('click', function() {
    const supplier = $('#supplier').val();
    const user_id = $('#user_id').val();
    const date = $('#date').val();
    const faktur = $('#faktur').val();
    
    if (!supplier || !date || !faktur) {
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Lengkap',
            text: 'Harap isi faktur serta pilih supplier dan tanggal!'
        });
        return;
    }
    
    if (cart.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Cart Kosong',
            text: 'Tambahkan barang terlebih dahulu!'
        });
        return;
    }
    
    // Konfirmasi sebelum submit
    Swal.fire({
        title: 'Konfirmasi Simpan',
        text: 'Pastikan semua data sudah benar. Lanjutkan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            submitPurchase(supplier, user_id, date, faktur);
        }
    });
});

// Fungsi untuk submit pembelian
function submitPurchase(supplier, user_id,  date, faktur) {
    const cartData = JSON.stringify(cart);
    
    $.ajax({
        url: 'submit_cart.php',
        method: 'POST',
        data: { faktur, supplier, user_id, date, cart: cartData },
        success: function(response) {
          console.log(cartData)
            try {
                const result = response;
                if (result.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonText: 'Tutup',
                        showCancelButton: false
                    }).then(() => {
                        resetForm(); 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message
                    });
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses data'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal menghubungi server'
            });
        }
    });
}

// Fungsi untuk reset form
function resetForm() {
    cart = [];
    updateCartTable();
    $('#supplier').val('').trigger('change');
    $('#faktur').val('');
    $('#date').val('');
    $('#faktur').focus();
}
</script>
<?php include "src/footer.php" ?>