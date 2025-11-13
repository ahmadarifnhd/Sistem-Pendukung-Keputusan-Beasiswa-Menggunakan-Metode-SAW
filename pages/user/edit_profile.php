<?php
require 'config/koneksi_db.php';
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['masuk'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id']; // ID user dari session
$data = mysqli_query($koneksi, "SELECT * FROM data_user WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    die("Data user tidak ditemukan.");
}

// Proses update profil
if (isset($_POST['update'])) {
    $npm = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['npm']));
    $username = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['username']));
    $nama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $program_studi = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['program_studi']));
    $password = $_POST['password']; // password baru (boleh kosong)

    if ($password != '') {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE data_user SET npm='$npm', username='$username', nama='$nama', program_studi='$program_studi', password='$password' WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE data_user SET npm='$npm', username='$username', nama='$nama', program_studi='$program_studi' WHERE id='$id'");
    }

    // Update session username
    $_SESSION['username'] = $username;
    // Update session nama (jika diperlukan)
    $_SESSION['nama'] = $nama;

    echo "<script>alert('Profil berhasil diupdate!'); window.location='index.php';</script>";
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Profile</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($row['nama'] ?? $row['username']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" value="<?= htmlspecialchars($row['npm']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="program_studi" value="<?= htmlspecialchars($row['program_studi'] ?? ''); ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($row['username']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password <small>(Kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Password baru">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>