<?php
require 'config/koneksi_db.php';

if (!isset($_GET['id'])) {
    die("ID user tidak ditemukan.");
}

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM data_user WHERE id='$id'");

if (!$data) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$row = mysqli_fetch_assoc($data);

if (!$row) {
    die("Data user dengan ID $id tidak ditemukan.");
}
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit User</h3>
    </div>
    <form action="index.php?page=proses_update_user" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="card-body">
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" class="form-control" value="<?= $row['npm']; ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= $row['username']; ?>" required>
            </div>
            <div class="form-group">
                <label>Password <small>(Kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Isi jika ingin ganti password">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= $row['role']=='admin'?'selected':''; ?>>Admin</option>
                    <option value="user" <?= $row['role']=='user'?'selected':''; ?>>User</option>
                </select>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php?page=list_user" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>