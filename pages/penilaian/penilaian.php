<?php
// menampilkan seluruh data 
function tampilData($query)
{
    global $koneksi;

    $dataAlter = mysqli_query($koneksi, $query);
    $row = [];
    while ($data = mysqli_fetch_assoc($dataAlter)) {
        $row[] = $data;
    }

    return $row;
}
$alternatif = tampilData("SELECT * FROM data_alternatif");
$penilaian  = tampilData("SELECT * FROM data_penilaian");

// menyimpan data yang diinput
if (isset($_POST['simpan'])) {
    global $koneksi;

    $sql = "SELECT COUNT(*) FROM data_penilaian";
    $data = mysqli_query($koneksi, $sql);
    $isi = mysqli_fetch_row($data);

    if ($isi[0] == 20) {
        echo "<script>
              alert('Penilaian Hanya Bisa Input Maks 20 Data');
           </script>";
    } else if ($isi[0] !== 20) {
        $alternatif = htmlspecialchars($_POST['alternatif']);
        $nilai_c1 = isset($_POST['bobot_c1']) ? intval($_POST['bobot_c1']) : 0;
        $nilai_c2 = isset($_POST['bobot_c2']) ? intval($_POST['bobot_c2']) : 0;
        $nilai_c3 = isset($_POST['bobot_c3']) ? intval($_POST['bobot_c3']) : 0;
        $nilai_c4 = isset($_POST['bobot_c4']) ? intval($_POST['bobot_c4']) : 0;
        $nilai_c5 = isset($_POST['bobot_c5']) ? intval($_POST['bobot_c5']) : 0;

        // Mengambil ID terbesar dan menambah 1 untuk membuat ID baru
        $maxIdResult = mysqli_query($koneksi, "SELECT MAX(ID_Penilaian) as max_id FROM data_penilaian");
        $maxIdRow = mysqli_fetch_assoc($maxIdResult);
        $newId = ($maxIdRow['max_id'] !== null) ? $maxIdRow['max_id'] + 1 : 1;

        // Memasukkan data baru ke dalam database
        $query = "INSERT INTO data_penilaian (ID_Penilaian, Alternatif, AO, IPK, KKM, TMB, SMT) 
                VALUES ('$newId', '$alternatif', '$nilai_c1', '$nilai_c2', '$nilai_c3', '$nilai_c4', '$nilai_c5')";
        mysqli_query($koneksi, $query);

        echo "<script>
              alert('Data Penilaian Berhasil Disimpan');
              document.location.href = 'index.php?page=data_penilaian';
           </script>";
    }
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penilaian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?beranda.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Penilaian</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Silahkan Masukan Penilaian</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Kriteria</h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Penilaian</h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Alternatif</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control select2" style="width: 100%;" name="alternatif">
                                <option selected="selected" disabled>-- Pilih Alternatif --</option>
                                <?php
                                foreach ($alternatif as $items) {
                                ?>
                                    <option value="<?= $items['Nama_Mahasiswa']; ?>"><?= $items['Nama_Mahasiswa']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
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
                    <div class="simpan text-right">
                        <button type="submit" class="btn btn-primary" name="simpan"><i class="far fa-save"></i>
                            Simpan</button>
                    </div>
                </form>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-nowrap">Kode</th>
                                        <th class="text-nowrap">Alternatif</th>
                                        <th class="text-nowrap">C1</th>
                                        <th class="text-nowrap">C2</th>
                                        <th class="text-nowrap">C3</th>
                                        <th class="text-nowrap">C4</th>
                                        <th class="text-nowrap">C5</th>
                                        <th class="text-nowrap">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($penilaian as $items) {
                                    ?>
                                        <tr>
                                            <td class="text-center text-nowrap"><?= 'A' . $no++; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['Alternatif']; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['AO']; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['IPK']; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['KKM']; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['TMB']; ?></td>
                                            <td class="text-center text-nowrap"><?= $items['SMT']; ?></td>
                                            <td class="text-nowrap">
                                                <center>
                                                    <a
                                                        href="index.php?page=edit_penilaian&id=<?= $items['ID_Penilaian']; ?>">
                                                        <button type="button" class="btn btn-primary"><i
                                                                class="far fa-edit"></i> Edit</button>
                                                    </a>
                                                    <a
                                                        href="index.php?page=delete_penilaian&id=<?= $items['ID_Penilaian']; ?>">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="return confirm('Hapus Penilaian Kriteria?');"><i
                                                                class="far fa-trash-alt"></i> Delete</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end mt-6">
                                <form method="post" action="index.php?page=perhitungan">
                                    <button type="submit" class="btn btn-primary px-4" name="hitung">
                                        <i class="far fa-hourglass px-1"></i> Hitung
                                    </button>
                                </form>
                            </div>


                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->