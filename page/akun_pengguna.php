<?php include 'src/header.php' ?>
<?php 
$newNip = generateNewNIP();

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $nip = $_POST['nip'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($name) || empty($nip) || empty($username) || empty($password)) {
        echo "<script>alert('Semua field harus diisi.');</script>";
    } else {
        try {
            $response = addUser($nip, $name, $username, $password);
        
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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    try {
        $response = updateUser($id, $name, $username, $password, $role);

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
        $response = deleteUser($id);

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
        <button type="button" class="btn btn-success mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#newUser">
            <i class="fas fa-plus"></i>
            Data User Baru
        </button>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Master User
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $suppliers = getUsers();
                        $no = 1;
                        foreach ($suppliers as $item) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$item['nip']}</td>
                                    <td>{$item['role']}</td>
                                    <td>{$item['name']}</td>
                                    <td>{$item['username']}</td>
                                    <td>{$item['password']}</td>
                                    <td>
                                        <button type='button' 
                                                class='btn btn-primary btn-sm edit-btn' 
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editModal'
                                                data-id='{$item['id']}'
                                                data-name='{$item['name']}'
                                                data-username='{$item['username']}'
                                                data-password='{$item['password']}'
                                                data-role='{$item['role']}'>
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
<div class="modal fade" id="newUser" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" id="nip" value="<?= $newNip ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nama User</label>
                        <input type="text" name="name" class="form-control" id="user_name" placeholder="Masukkan nama user" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="">Pilih Kategori</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama user</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <textarea name="username" class="form-control" id="edit_username" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">password </label>
                        <input type="text" name="password" class="form-control" id="edit_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role</label>
                        <select name="role" class="form-control" id="edit_role" required>
                            <option value="">Pilih Role</option>
                            <?php
                            // Misalkan Anda mendapatkan data pengguna melalui fungsi getUsers()
                            $users = getUsers();
                            
                            // Ambil role_id yang sudah ada sebelumnya, misalnya saat edit data user
                            $selectedRole = isset($user['role']) ? $user['role'] : '';  // Pastikan 'role' ada di data user yang diedit
                            
                            // Loop untuk menampilkan role dalam dropdown
                            $roles = ['admin', 'user'];  // Anda bisa menyesuaikan dengan role yang ada di sistem Anda
                            foreach ($roles as $role) {
                                // Tentukan apakah role saat ini adalah yang dipilih
                                $isSelected = ($role === $selectedRole) ? 'selected' : '';
                                echo "<option value='$role' $isSelected>$role</option>";
                            }
                            ?>
                        </select>
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
        const username = button.getAttribute('data-username');
        const password = button.getAttribute('data-password');
        const role = button.getAttribute('data-role');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_password').value = password;
        document.getElementById('edit_role').value = role;

        const roleSelect = document.getElementById('edit_role');
        for (let option of roleSelect.options) {
            option.selected = (option.value === categoryId);
        }
    });

    editModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('editForm').reset();

        const roleSelect = document.getElementById('edit_role');
        for (let option of roleSelect.options) {
            option.selected = false;
        }
    });
});
</script>

<?php include "src/footer.php" ?>