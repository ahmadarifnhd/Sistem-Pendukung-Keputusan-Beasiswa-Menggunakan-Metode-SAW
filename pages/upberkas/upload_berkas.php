<?php
require 'config/koneksi_db.php';
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['masuk'])) {
    header('Location: beasiswa.php');
    exit;
}

$npm_session = isset($_SESSION['npm']) ? trim($_SESSION['npm']) : '';
$npm_session_esc = mysqli_real_escape_string($koneksi, $npm_session);
$user = null;

if ($npm_session !== '') {
    $q = mysqli_query($koneksi, "SELECT id, nama, npm, program_studi, username FROM data_user WHERE TRIM(npm) = '{$npm_session_esc}' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $user = mysqli_fetch_assoc($q);
    }
}

if (!$user && !empty($_SESSION['id'])) {
    $id_sess = (int)$_SESSION['id'];
    $q2 = mysqli_query($koneksi, "SELECT id, nama, npm, program_studi, username FROM data_user WHERE id = {$id_sess} LIMIT 1");
    if ($q2 && mysqli_num_rows($q2) > 0) {
        $user = mysqli_fetch_assoc($q2);
    }
}

if ($user) {
    $nama_mahasiswa = !empty($user['nama']) ? $user['nama'] : (!empty($user['username']) ? $user['username'] : '');
    $npm_db_value = !empty($user['npm']) ? trim($user['npm']) : '';
    $program_studi = !empty($user['program_studi']) ? $user['program_studi'] : '';
} else {
    $nama_mahasiswa = !empty($_SESSION['username']) ? $_SESSION['username'] : '';
    $npm_db_value = $npm_session;
}

$role_session = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$cek_npm = mysqli_real_escape_string($koneksi, trim($npm_db_value));
if ($role_session === 'user' && $cek_npm !== '') {
    $cek = mysqli_query($koneksi, "SELECT id FROM tbl_berkas WHERE TRIM(npm) = '{$cek_npm}' LIMIT 1");
    if ($cek && mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Anda sudah melakukan upload berkas, tidak bisa menambah lagi!'); window.location.href='index.php?page=list_berkas2';</script>";
        exit;
    }
}

$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "berkas" . DIRECTORY_SEPARATOR;
$webUploadBase = "pages/upberkas/uploads/berkas/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Fungsi upload file dengan validasi ekstensi & ukuran
function uploadFile($fieldName, $uploadDir, $webBase, $allowedExt = ['pdf', 'doc', 'docx'], $maxSize = 5 * 1024 * 1024)
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $tmp = $_FILES[$fieldName]['tmp_name'];
    $orig = $_FILES[$fieldName]['name'];
    $size = $_FILES[$fieldName]['size'];

    // Cek ukuran
    if ($size > $maxSize) {
        return null;
    }

    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    if ($ext !== '' && !in_array($ext, $allowedExt, true)) {
        return null;
    }

    // Nama file aman
    try {
        $rand = bin2hex(random_bytes(6));
    } catch (Exception $e) {
        $rand = substr(md5(uniqid('', true)), 0, 12);
    }
    $fileName = time() . "_" . $rand . ($ext ? "." . $ext : "");
    $target = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

    if (move_uploaded_file($tmp, $target)) {
        return $webBase . $fileName;
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form (prioritaskan input POST jika ada), tetap sanitize dan batasi jika role user
    $nama_input   = isset($_POST['nama_mahasiswa']) ? trim($_POST['nama_mahasiswa']) : '';
    $npm_input    = isset($_POST['npm']) ? trim($_POST['npm']) : '';
    $prodi_input  = isset($_POST['program_studi']) ? trim($_POST['program_studi']) : '';

    // Jika user biasa, paksa npm dari session (agar tidak bisa memalsukan npm)
    if ($role_session === 'user' && $npm_db_value !== '') {
        $npm_used = $npm_db_value;
    } else {
        // gunakan input jika disediakan, fallback ke nilai yang diambil dari DB/session sebelumnya
        $npm_used = $npm_input !== '' ? $npm_input : $npm_db_value;
    }

    $nama_db    = mysqli_real_escape_string($koneksi, $nama_input !== '' ? $nama_input : $nama_mahasiswa);
    $npm_db     = mysqli_real_escape_string($koneksi, $npm_used);
    $program_db = mysqli_real_escape_string($koneksi, $prodi_input !== '' ? $prodi_input : $program_studi);

    $jumlah_sks = isset($_POST['jumlah_sks']) ? (int)$_POST['jumlah_sks'] : 0;
    if ($jumlah_sks < 0) $jumlah_sks = 0;
    if ($jumlah_sks > 40) $jumlah_sks = 40;

    // simpan status dalam lowercase agar konsisten dengan tampilan list_berkas2
    $status = "pending";

    // Upload file-file yang diperlukan
    $file_organisasi = uploadFile('file_aktif_organisasi', $uploadDir, $webUploadBase);
    $file_beasiswa   = uploadFile('file_tidak_beasiswa', $uploadDir, $webUploadBase);
    $file_keluarga   = uploadFile('file_keluarga_tidak_mampu', $uploadDir, $webUploadBase);
    $file_ipk        = uploadFile('file_ipk', $uploadDir, $webUploadBase);

    // Siapkan dan eksekusi prepared statement untuk insert
    $stmt = mysqli_prepare($koneksi, "INSERT INTO tbl_berkas 
        (nama_mahasiswa, npm, program_studi, jumlah_sks, file_aktif_organisasi, file_tidak_beasiswa, file_keluarga_tidak_mampu, file_ipk, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $f_org = $file_organisasi ?? '';
        $f_bea = $file_beasiswa ?? '';
        $f_kel = $file_keluarga ?? '';
        $f_ipk = $file_ipk ?? '';
        mysqli_stmt_bind_param($stmt, "sssisssss", $nama_db, $npm_db, $program_db, $jumlah_sks, $f_org, $f_bea, $f_kel, $f_ipk, $status);
        $exec = mysqli_stmt_execute($stmt);
        if ($exec) {
            if ($role_session === 'user') {
                echo "<script>alert('Berkas berhasil diupload!'); window.location.href='index.php?page=list_berkas2';</script>";
            } else {
                echo "<script>alert('Berkas berhasil diupload!'); window.location.href='index.php?page=list_berkas';</script>";
            }
            mysqli_stmt_close($stmt);
            exit;
        } else {
            $err = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            echo "Error saat menyimpan data: " . htmlspecialchars($err);
        }
    } else {
        echo "Error query: " . mysqli_error($koneksi);
    }
}

// Atur atribut readonly untuk field yang tidak boleh diubah oleh user biasa
$readonly_attr = ($role_session === 'user') ? 'readonly' : '';
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Upload Berkas</h3>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <label>Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" value="<?= htmlspecialchars($nama_mahasiswa); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>NPM</label>
                <input type="text" name="npm" value="<?= htmlspecialchars($npm_db_value); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="program_studi" value="<?= htmlspecialchars($program_studi); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah SKS</label>
                <input type="number" name="jumlah_sks" max="40" class="form-control" required>
            </div>
            <div class="form-group">
                <label>File Aktif Organisasi (pdf/doc/docx, max 5MB)</label>
                <input type="file" name="file_aktif_organisasi" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <label>File Tidak Menerima Beasiswa (pdf/doc/docx, max 5MB)</label>
                <input type="file" name="file_tidak_beasiswa" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <label>File Keluarga Tidak Mampu (pdf/doc/docx, max 5MB)</label>
                <input type="file" name="file_keluarga_tidak_mampu" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <label>File IPK (pdf/doc/docx, max 5MB)</label>
                <input type="file" name="file_ipk" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="index.php?page=list_berkas2" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>