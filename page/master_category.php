<?php include "src/header.php" ?>
<?php 

if (isset($_POST['save'])) {

    $name = $_POST['category_name'];

    if (empty($name)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = addMasterCategory($name);
        
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
    
    try {
        $response = updateMasterCategory($id, $name);

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
        $response = deleteMastercategory($id);

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
            alert('Gagal menghapus data: Data berada di tabel lain.');
            window.history.back(); 
        </script>";
    }
}


?>


<main>
    <div class="container-fluid px-4">
        <button type="button" class="btn btn-success mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#newMasterCategory">
            <i class="fas fa-plus"></i>
            Data Kategori Baru
        </button>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Master Kategori
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category Id</th>
                            <th>Category Name</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $category = getMasterCategory();
                        $no = 1;
                        foreach ($category as $item) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>CATEGORY-{$item['id']}</td>
                                    <td>{$item['category_name']}</td>
                                    <td>
                                        <button type='button' 
                                                class='btn btn-primary btn-sm edit-btn' 
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editModal'
                                                data-id='{$item['id']}'
                                                data-name='{$item['category_name']}'>
                                            Edit
                                        </button>
                                        <a href='?delete_id={$item['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this?\")'>Hapus</a>
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
<div class="modal fade" id="newMasterCategory" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Nama Kategori</label>
                        <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Masukkan nama kategori" required>
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
                <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Kategori Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
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

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
    });

    editModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('editForm').reset();
    });
});
</script>

<?php include "src/footer.php" ?>