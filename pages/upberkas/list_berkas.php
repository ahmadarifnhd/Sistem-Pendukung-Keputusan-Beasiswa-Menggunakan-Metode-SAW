<?php
require 'config/koneksi_db.php';

// Update status
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    mysqli_query($koneksi, "UPDATE tbl_berkas SET status='$status' WHERE id='$id'");
    echo "<script>alert('Status berhasil diupdate!'); window.location='index.php?page=list_berkas';</script>";
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tbl_berkas WHERE id='$id'");
    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php?page=list_berkas';</script>";
}

// Ambil data
$result = mysqli_query($koneksi, "SELECT * FROM tbl_berkas ORDER BY id DESC");
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Berkas</h3>
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
                <?php $no=1; while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                    <td><?= htmlspecialchars($row['npm']); ?></td>
                    <td><?= htmlspecialchars($row['program_studi']); ?></td>
                    <td><?= htmlspecialchars($row['jumlah_sks']); ?></td>
                    <td>
                        <a href="<?= $row['file_aktif_organisasi']; ?>" target="_blank">Aktif Organisasi</a><br>
                        <a href="<?= $row['file_tidak_beasiswa']; ?>" target="_blank">Tidak Beasiswa</a><br>
                        <a href="<?= $row['file_keluarga_tidak_mampu']; ?>" target="_blank">Keluarga Tidak Mampu</a><br>
                        <a href="<?= $row['file_ipk']; ?>" target="_blank">IPK</a>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <select name="status" class="form-control form-control-sm">
                                <option value="pending" <?= $row['status']=='pending'?'selected':''; ?>>Pending</option>
                                <option value="diterima" <?= $row['status']=='diterima'?'selected':''; ?>>Diterima
                                </option>
                                <option value="ditolak" <?= $row['status']=='ditolak'?'selected':''; ?>>Ditolak</option>
                            </select>
                            <button type="submit" name="update_status"
                                class="btn btn-sm btn-success mt-1">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="index.php?page=edit_berkas&id=<?= $row['id']; ?>"
                            class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?page=list_berkas&hapus=<?= $row['id']; ?>"
                            onclick="return confirm('Yakin hapus data ini?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>