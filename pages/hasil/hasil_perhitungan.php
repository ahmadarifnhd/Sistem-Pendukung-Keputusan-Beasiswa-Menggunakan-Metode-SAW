<?php
require 'pages/perhitungan/proses_perhitungan.php';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Hasil Perhitungan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?beranda.php">Beranda</a></li>
          <li class="breadcrumb-item active">Hasil Perhitungan</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <!-- Bagian 1: Hasil Normalisasi (label + tabel) -->
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title">Hasil Normalisasi</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th class="text-nowrap">Kriteria</th>
                <?php foreach ($alternatif as $alt) { ?>
                  <th class="text-nowrap"><?= htmlspecialchars($alt['Nama_Mahasiswa']); ?></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $kriteria = ['C1', 'C2', 'C3', 'C4', 'C5'];
              foreach ($kriteria as $kri) {
                echo "<tr>";
                echo "<td class='font-weight-bold text-nowrap'>{$kri}</td>";
                foreach ($hasilNormalisasi as $data) {
                  // tampilkan nilai jika ada, else '-'
                  $val = isset($data[$kri]) ? $data[$kri] : '-';
                  echo "<td>{$val}</td>";
                }
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Bagian 2: Hasil Preferensi (label + tabel) -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Hasil Preferensi</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th class="text-nowrap">Peringkat</th>
                <th class="text-nowrap">Alternatif</th>
                <th class="text-nowrap">C1</th>
                <th class="text-nowrap">C2</th>
                <th class="text-nowrap">C3</th>
                <th class="text-nowrap">C4</th>
                <th class="text-nowrap">C5</th>
                <th class="text-nowrap">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($hasilPreferensi as $data) {
                $idAlt = $data['ID_Alternatif'];
                $nama = '-';
                foreach ($alternatif as $alt) {
                  if ($alt['ID_Alternatif'] == $idAlt) {
                    $nama = $alt['Nama_Mahasiswa'];
                    break;
                  }
                }
              ?>
                <tr>
                  <td class="text-nowrap"><?= $no; ?></td>
                  <td class="text-nowrap"><?= htmlspecialchars($nama); ?></td>
                  <td class="text-nowrap"><?= $data['C1']; ?></td>
                  <td class="text-nowrap"><?= $data['C2']; ?></td>
                  <td class="text-nowrap"><?= $data['C3']; ?></td>
                  <td class="text-nowrap"><?= $data['C4']; ?></td>
                  <td class="text-nowrap"><?= $data['C5']; ?></td>
                  <td class="text-nowrap"><?= $data['Total']; ?></td>
                </tr>
              <?php
                $no++;
              }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Tombol Cetak Hasil & Reset Ulang (di posisi kanan bawah) -->
        <div class="row text-right mt-3">
          <div class="col">
            <form method="post" class="d-flex justify-content-end">
              <div class="opsi-2">
                <a href="pages/perhitungan/Cetak_Hasil.php" target="_blank">
                  <button type="button" class="btn btn-primary"><i class="far fa-file-pdf"></i> Cetak Hasil</button>
                </a>
                <button type="submit" class="btn btn-primary" name="reset" onclick="return confirm('Yakin ingin reset ulang? Semua data serta hasil akan terhapus semua'); "><i class="fas fa-redo"></i> Reset Ulang</button>
              </div>
            </form>
          </div>
        </div>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>
</section>