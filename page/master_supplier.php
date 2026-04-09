<?php include "src/header.php" ?>
<?php 

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    if (empty($name) || empty($address) || empty($contact)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = addMasterSupplier($name, $address, $contact);
        
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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    
    try {
        $response = updateMasterSupplier($id, $name, $address, $contact);

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
        $response = deleteMasterSupplier($id);

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
        <button type="button" class="btn btn-success mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#newMasterSupplier">
            <i class="fas fa-plus"></i>
            Data Supplier Baru
        </button>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Master Supplier
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Supplier Id</th>
                            <th>Supplier Name</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $suppliers = getSuppliers();
                        $no = 1;
                        foreach ($suppliers as $item) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>SPL-{$item['id']}</td>
                                    <td>{$item['name']}</td>
                                    <td>{$item['address']}</td>
                                    <td>{$item['contact_info']}</td>
                                    <td>
                                        <button type='button' 
                                                class='btn btn-primary btn-sm edit-btn' 
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editModal'
                                                data-id='{$item['id']}'
                                                data-name='{$item['name']}'
                                                data-address='{$item['address']}'
                                                data-contact='{$item['contact_info']}'>
                                            Edit
                                        </button>
                                        <a href='?delete_id={$item['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this ?\")'>Hapus</a>
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
<div class="modal fade" id="newMasterSupplier" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Supplier Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="supplier_name" class="form-label">Nama Supplier</label>
                        <input type="text" name="name" class="form-control" id="supplier_name" placeholder="Masukkan nama supplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" id="address" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Info</label>
                        <input type="text" name="contact" class="form-control" id="contact" placeholder="Masukkan informasi kontak" required>
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
                <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" id="edit_address" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact" class="form-label">Contact Info</label>
                        <input type="text" name="contact" class="form-control" id="edit_contact" placeholder="Masukkan informasi kontak" required>
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
        const name = button.getAttribute('data-name');
        const address = button.getAttribute('data-address');
        const contact = button.getAttribute('data-contact');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_address').value = address;
        document.getElementById('edit_contact').value = contact;
    });

    editModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('editForm').reset();
    });
});
</script>

<?php include "src/footer.php" ?>