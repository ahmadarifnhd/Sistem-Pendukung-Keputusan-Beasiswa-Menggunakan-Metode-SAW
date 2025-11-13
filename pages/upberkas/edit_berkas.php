<?php
require 'config/koneksi_db.php';
session_start();

// Pastikan login
if (!isset($_SESSION['masuk'])) {
    header('Location: beasiswa.php');
    exit;
}

$role_session = $_SESSION['role'];
$npm_session = $_SESSION['npm'];

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM tbl_berkas WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    die("Data berkas tidak ditemukan.");
}

// Jika role user, hanya boleh edit berkas milik sendiri
if ($role_session == 'user' && $row['npm'] != $npm_session) {
    echo "<script>alert('Anda tidak punya akses untuk mengedit berkas ini!'); window.location='index.php?page=list_berkas2';</script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $npm = $_POST['npm'];
    $program_studi = $_POST['program_studi'];
    $jumlah_sks = $_POST['jumlah_sks'];

    $uploadDir = "uploads/";

    // Fungsi update file jika ada upload baru
    function updateFile($fieldName, $oldFile, $uploadDir) {
        if ($_FILES[$fieldName]['name'] != '') {
            $newFile = $uploadDir . time() . "_" . basename($_FILES[$fieldName]['name']);
            move_uploaded_file($_FILES[$fieldName]['tmp_name'], $newFile);
            return $newFile;
        }
        return $oldFile;
    }

    $file_aktif_organisasi = updateFile('file_aktif_organisasi', $row['file_aktif_organisasi'], $uploadDir);
    $file_tidak_beasiswa   = updateFile('file_tidak_beasiswa', $row['file_tidak_beasiswa'], $uploadDir);
    $file_keluarga_tidak_mampu = updateFile('file_keluarga_tidak_mampu', $row['file_keluarga_tidak_mampu'], $uploadDir);
    $file_ipk = updateFile('file_ipk', $row['file_ipk'], $uploadDir);

    mysqli_query($koneksi, "UPDATE tbl_berkas SET 
        nama_mahasiswa='$nama_mahasiswa',
        npm='$npm',
        program_studi='$program_studi',
        jumlah_sks='$jumlah_sks',
        file_aktif_organisasi='$file_aktif_organisasi',
        file_tidak_beasiswa='$file_tidak_beasiswa',
        file_keluarga_tidak_mampu='$file_keluarga_tidak_mampu',
        file_ipk='$file_ipk'
        WHERE id='$id'
    ");

    // Redirect sesuai role
    if ($role_session == 'user') {
        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php?page=list_berkas2';</script>";
    } else {
        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php?page=list_berkas';</script>";
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Berkas</h3>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" value="<?= $row['nama_mahasiswa']; ?>" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" value="<?= $row['npm']; ?>" class="form-control"
                    <?= $role_session=='user'?'readonly':'' ?> required>
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="program_studi" value="<?= $row['program_studi']; ?>" class="form-control"
                    required>
            </div>
            <div class="form-group">
                <label>Jumlah SKS</label>
                <input type="number" name="jumlah_sks" value="<?= $row['jumlah_sks']; ?>" class="form-control" required>
            </div>

            <?php
            // Tampilkan file upload & link hanya jika role user atau admin
            $files = [
                'file_aktif_organisasi' => 'Aktif Organisasi',
                'file_tidak_beasiswa' => 'Tidak Beasiswa',
                'file_keluarga_tidak_mampu' => 'Keluarga Tidak Mampu',
                'file_ipk' => 'IPK'
            ];
            foreach ($files as $field => $label) {
                echo '<div class="form-group">';
                echo "<label>$label</label><br>";
                echo '<a href="'.$row[$field].'" target="_blank">Lihat File</a>';
                echo '<input type="file" name="'.$field.'" class="form-control mt-2">';
                echo '</div>';
            }
            ?>

            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>