<?php
require 'config/koneksi_db.php';
session_start();

if (!headers_sent()) {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
} else {
    echo '<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">';
    echo '<meta http-equiv="Pragma" content="no-cache">';
    echo '<meta http-equiv="Expires" content="0">';
}

if (!isset($_SESSION['masuk'])) {
    header("Location: login.php");
    exit;
}

// Determine current user's NPM reliably (try session npm, then session id, then session username)
$npm_login = '';
if (!empty($_SESSION['npm'])) {
    $npm_login = trim($_SESSION['npm']);
} elseif (!empty($_SESSION['id'])) {
    $id_sess = (int) $_SESSION['id'];
    $q = mysqli_query($koneksi, "SELECT npm FROM data_user WHERE id = {$id_sess} LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_assoc($q);
        $npm_login = trim($r['npm']);
    }
} elseif (!empty($_SESSION['username'])) {
    $username = mysqli_real_escape_string($koneksi, trim($_SESSION['username']));
    $q = mysqli_query($koneksi, "SELECT npm FROM data_user WHERE username = '{$username}' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_assoc($q);
        $npm_login = trim($r['npm']);
    }
}


$npm_login = $npm_login === null ? '' : trim($npm_login);
$npm_login_esc = mysqli_real_escape_string($koneksi, $npm_login);

// Primary query by npm
$cek_sql = "SELECT * FROM tbl_berkas WHERE TRIM(npm)='{$npm_login_esc}'";
$cek = mysqli_query($koneksi, $cek_sql);
$jumlah_berkas = $cek ? mysqli_num_rows($cek) : 0;
$result_sql = "SELECT * FROM tbl_berkas WHERE TRIM(npm)='{$npm_login_esc}' ORDER BY id DESC";
$result = mysqli_query($koneksi, $result_sql);

// fallback: jika tidak ditemukan via npm, coba cari berdasarkan nama/username
if ($jumlah_berkas == 0) {
    $fallback_done = false;
    if (!empty($_SESSION['username'])) {
        $uname = mysqli_real_escape_string($koneksi, trim($_SESSION['username']));
        $cek2_sql = "SELECT * FROM tbl_berkas WHERE TRIM(nama_mahasiswa) = '{$uname}' OR TRIM(npm)='{$uname}' OR nama_mahasiswa LIKE '%{$uname}%'";
        $cek2 = mysqli_query($koneksi, $cek2_sql);
        if ($cek2 && mysqli_num_rows($cek2) > 0) {
            $jumlah_berkas = mysqli_num_rows($cek2);
            $result_sql = "SELECT * FROM tbl_berkas WHERE TRIM(nama_mahasiswa) = '{$uname}' OR TRIM(npm)='{$uname}' OR nama_mahasiswa LIKE '%{$uname}%' ORDER BY id DESC";
            $result = mysqli_query($koneksi, $result_sql);
            $fallback_done = true;
        }
    }

    // tambahan debug (hilangkan di produksi): jika masih 0, Anda bisa cek isi variabel npm/session
    if (!$fallback_done && $jumlah_berkas == 0) {
        // Uncomment baris berikut saat debugging:
        // error_log("DEBUG list_berkas2: npm_login=" . var_export($npm_login, true) . " username=" . var_export($_SESSION['username'] ?? null, true));
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Berkas Saya</h3>
        <?php if ($jumlah_berkas == 0): ?>
            <a href="index.php?page=upload_berkas" class="btn btn-primary btn-sm float-right">+ Upload Baru</a>
        <?php else: ?>
            <button class="btn btn-secondary btn-sm float-right"
                onclick="alert('Anda sudah pernah meng-upload berkas, tidak bisa tambah lagi!')">+ Upload Baru</button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-secondary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NPM</th>
                    <th>Program Studi</th>
                    <th>Jumlah SKS</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($jumlah_berkas > 0): $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                            <td><?= htmlspecialchars($row['npm']); ?></td>
                            <td><?= htmlspecialchars($row['program_studi']); ?></td>
                            <td><?= htmlspecialchars($row['jumlah_sks']); ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($row['file_aktif_organisasi']); ?>" target="_blank">Aktif Organisasi</a><br>
                                <a href="<?= htmlspecialchars($row['file_tidak_beasiswa']); ?>" target="_blank">Tidak Beasiswa</a><br>
                                <a href="<?= htmlspecialchars($row['file_keluarga_tidak_mampu']); ?>" target="_blank">Keluarga Tidak Mampu</a><br>
                                <a href="<?= htmlspecialchars($row['file_ipk']); ?>" target="_blank">IPK</a>
                            </td>
                            <td>
                                <span class="badge <?= $row['status'] == 'pending' ? 'bg-warning' : ($row['status'] == 'diterima' ? 'bg-success' : 'bg-danger'); ?>">
                                    <?= ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?page=edit_berkas&id=<?= (int)$row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada berkas yang di-upload.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>