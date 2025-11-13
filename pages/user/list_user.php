<?php  
require 'config/koneksi_db.php';

// Fungsi tampil data
function tampilData($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $row = [];
    while($data = mysqli_fetch_assoc($result)){
        $row[] = $data;
    }
    return $row;
}

// Tambahkan kolom npm di SELECT
$hasil = tampilData("SELECT id, npm, username, password, role FROM data_user");
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data User</h1>
            </div>
            <div class="col-sm-6">
                <a href="index.php?page=add_user" class="btn btn-success float-right">+ Tambah User</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center bg-light">
                                    <th>No</th>
                                    <th>NPM</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($hasil)) : $no=1; ?>
                                <?php foreach($hasil as $items) : ?>
                                <tr class="text-center">
                                    <td><?= $no++; ?></td>
                                    <td><?= $items['npm']; ?></td> <!-- Tampilkan NPM -->
                                    <td><?= $items['username']; ?></td>
                                    <td>********</td> <!-- Sembunyikan hash password -->
                                    <td><?= $items['role']; ?></td>
                                    <td>
                                        <a href="index.php?page=edit_user&id=<?= $items['id']; ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <a href="index.php?page=delete_user&id=<?= $items['id']; ?>"
                                            class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?');">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data user</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>