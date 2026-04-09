<?php include "src/header.php" ?>
<?php 

$categories = getMasterCategory();

if (isset($_POST['save'])) {
    $product_name = $_POST['nama'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if (empty($price) || empty($product_name) || empty($category_id)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = addMasterBarang($product_name, $stock, $price, $category_id);
        
            if ($response['status']) {
                echo "<script>
                    alert('Data sukses ditambahkan.');
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

if (isset($_POST['edit'])) {

    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $category = $_POST['category_id'];
    
    try {
        $response = updateMasterBarang($id, $name, $stock, $price, $category);

        if ($response) {
            echo "<script>
                alert('Data berhasil diupdate.');
                window.history.back(); 
            </script>";
        } else {
            throw new Exception("Gagal mengupdate data.");
        }
    } catch (Exception $e) {
        echo "<script>
            alert('Gagal mengupdate data: {$e->getMessage()}.');
            window.history.back(); 
        </script>";
    }

}

if (isset($_GET['delete_id'])) {

    $id = $_GET['delete_id'];

    try {
        $response = deleteMasterBarang($id);

        if ($response) {
            echo "<script>
                alert('Data berhasil dihapus.');
                window.history.back(); 
            </script>";
        } else {
            throw new Exception("Gagal menghapus data.");
        }
    } catch (Exception $e) {
        echo "<script>
            alert('Gagal menghapus data: {$e->getMessage()}.');
            window.history.back(); 
        </script>";
    }
}


?>


<main>
    <div class="container-fluid px-4">
        <button type="button" class="btn btn-success mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#newMasterBarang">
            <i class="fas fa-plus"></i>
            Data Barang Baru
        </button>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Master Barang
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Aksi</th>
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
                                    <td>{$item['price']}</td>
                                    <td>
                                        <button type='button' 
                                                class='btn btn-primary btn-sm edit-btn' 
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editModal'
                                                data-id='{$item['id']}'
                                                data-category-id='{$item['category_id']}'
                                                data-name='{$item['name']}'
                                                data-price='{$item['price']}'
                                                data-stock='{$item['stock']}'>
                                            Edit
                                        </button>
                                        <a href='?delete_id={$item['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Hapus</a>
                                    </td>
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



<!-- Modal Add Data -->
<div class="modal fade" id="newMasterBarang" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" id="product_name" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Produk</label>
                        <input type="number" name="price" class="form-control" id="price" placeholder="Masukkan harga produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select name="category_id" class="form-control" id="category" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" id="stock" placeholder="Masukkan jumlah stok" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button name="save" type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
                </form>
        </div>
    </div>
</div>


<!-- Modal Edti data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Kategori</label>
                        <select name="category_id" class="form-control" id="edit_category" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $categories = getMasterCategory();
                            foreach ($categories as $category) {
                                echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="edit_stock" name="stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="edit" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');
    
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const categoryId = button.getAttribute('data-category-id');
        const name = button.getAttribute('data-name');
        const stock = button.getAttribute('data-stock');
        const price = button.getAttribute('data-price');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_price').value = price;

        const categorySelect = document.getElementById('edit_category');
        for (let option of categorySelect.options) {
            option.selected = (option.value === categoryId);
        }
    });

    editModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('editForm').reset();

        const categorySelect = document.getElementById('edit_category');
        for (let option of categorySelect.options) {
            option.selected = false;
        }
    });
});
</script>

<?php include "src/footer.php" ?>