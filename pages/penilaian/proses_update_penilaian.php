<?php
// menampilkan data yang dipilih
$id = $_GET['id'];
$query = "SELECT * FROM data_penilaian WHERE ID_Penilaian = '$id'";
$data = mysqli_query($koneksi, $query);
$hasil = mysqli_fetch_assoc($data);

// mengubah / edit data
if (isset($_POST['edit'])) {
  $idPenilai = $_POST['idPenilai'];
  $alternatif = htmlspecialchars($_POST['alternatif']);
  $nilai_c1 = isset($_POST['bobot_c1']) ? intval($_POST['bobot_c1']) : 0;
  $nilai_c2 = isset($_POST['bobot_c2']) ? intval($_POST['bobot_c2']) : 0;
  $nilai_c3 = isset($_POST['bobot_c3']) ? intval($_POST['bobot_c3']) : 0;
  $nilai_c4 = isset($_POST['bobot_c4']) ? intval($_POST['bobot_c4']) : 0;
  $nilai_c5 = isset($_POST['bobot_c5']) ? intval($_POST['bobot_c5']) : 0;

    $query = "UPDATE data_penilaian SET 
                Alternatif = '$alternatif',
                AO      = '$nilai_c1',
                IPK     = '$nilai_c2',
                KKM     = '$nilai_c3',
                TMB     = '$nilai_c4',
                SMT     = '$nilai_c5'
              WHERE ID_Penilaian = '$idPenilai'";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>
                alert('Data berhasil diupdate');
                document.location.href = 'index.php?page=data_penilaian';
              </script>";
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Penilaian</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?page=data_penilaian">Penilaian</a></li>
          <li class="breadcrumb-item active">Edit Penilaian</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Edit Data Penilaian</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form role="form" method="post">

          <input type="hidden" name="idPenilai" value="<?= $hasil['ID_Penilaian']; ?>">

          <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="font-weight-bold">Kriteria</h5>
            </div>
            <div class="col-md-6">
              <h5 class="font-weight-bold">Penilaian</h5>
            </div>
          </div>
          <div class="row mb-3" hidden="hidden">
            <div class="col-md-6">
              <label>ID Penilaian</label>
            </div>
            <div class="col-md-6">
              <input class="form-control select2" style="width: 100%;" placeholder="Nilai" name="nilai_c1" required value="<?= $hasil['ID_Penilaian']; ?>" disabled></input>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Alternatif</label>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control"
                value="<?= htmlspecialchars($hasil['Alternatif']); ?>" readonly>
              <!-- hidden supaya tetap terkirim ke POST -->
              <input type="hidden" name="alternatif" value="<?= htmlspecialchars($hasil['Alternatif']); ?>">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C1) Aktif Organisasi</label>
            </div>
            <div style="display: flex; gap: 25px; align-items: center;">
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c1" value="1" style="width: 20px; height: 20px;"> 1
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c1" value="2" style="width: 20px; height: 20px;"> 2
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c1" value="3" style="width: 20px; height: 20px;"> 3
              </label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C2) IPK > 3.25</label>
            </div>
            <div style="display: flex; gap: 25px; align-items: center;">
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c2" value="1" style="width: 20px; height: 20px;"> 1
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c2" value="2" style="width: 20px; height: 20px;"> 2
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c2" value="3" style="width: 20px; height: 20px;"> 3
              </label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C3) Keluarga Kurang Mampu</label>
            </div>
            <div style="display: flex; gap: 25px; align-items: center;">
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c3" value="1" style="width: 20px; height: 20px;"> 1
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c3" value="2" style="width: 20px; height: 20px;"> 2
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c3" value="3" style="width: 20px; height: 20px;"> 3
              </label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C4) Tidak Menerima Beasiswa Lain</label>
            </div>
            <div style="display: flex; gap: 25px; align-items: center;">
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c4" value="1" style="width: 20px; height: 20px;"> 1
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c4" value="2" style="width: 20px; height: 20px;"> 2
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c4" value="3" style="width: 20px; height: 20px;"> 3
              </label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C5) SKS</label>
            </div>
            <div style="display: flex; gap: 25px; align-items: center;">
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c5" value="1" style="width: 20px; height: 20px;"> 1
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c5" value="2" style="width: 20px; height: 20px;"> 2
              </label>
              <label style="font-size: 25px;">
                <input type="radio" name="bobot_c5" value="3" style="width: 20px; height: 20px;"> 3
              </label>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-4">
            <a href="index.php?page=data_penilaian">
              <button type="button" class="btn btn-primary">Kembali</button>
            </a>
            <button type="submit" class="btn btn-primary" name="edit">
              <i class="far fa-edit"></i> Update
            </button>
          </div>

        </form>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
