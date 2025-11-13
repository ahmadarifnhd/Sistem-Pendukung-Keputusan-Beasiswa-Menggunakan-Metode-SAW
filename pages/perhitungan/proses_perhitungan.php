<?php
// Menampilkan seluruh data
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
$kriteria = tampilData("SELECT * FROM data_kriteria");
$penilaian = tampilData("SELECT * FROM data_penilaian");

// Proses perhitungan
if (isset($_POST['hitung'])) {
    $sql1 = "SELECT COUNT(*) FROM data_penilaian";
    $dataPenilai = mysqli_query($koneksi, $sql1);
    $isiPenilai = mysqli_fetch_row($dataPenilai);

    $sql2 = "SELECT COUNT(*) FROM hasil_normalisasi";
    $dataNorm = mysqli_query($koneksi, $sql2);
    $isiNorm = mysqli_fetch_row($dataNorm);

    $sql3 = "SELECT COUNT(*) FROM hasil_preferensi";
    $dataPref = mysqli_query($koneksi, $sql3);
    $isiPref = mysqli_fetch_row($dataPref);

    if ($isiPenilai[0] == 0) {
    } else if ($isiNorm[0] > 0 && $isiPref[0] > 0) {
    } else {
        // Fungsi mengambil data dari DB    
        function Data($sql)
        {
            global $koneksi;

            $dataNilai = mysqli_query($koneksi, $sql);
            $baris = [];
            while ($hasil = mysqli_fetch_row($dataNilai)) {
                $baris[] = $hasil;
            }

            return $baris;
        }

        // Tambahkan definisi untuk variabel $ambil sebelum digunakan
        $ambil = Data("SELECT * FROM data_penilaian");

        // Proses normalisasi
        function normalisasi($dataPenilaian, $jenisKriteria)
        {
            global $koneksi;
            $jumlahAlternatif = count($dataPenilaian);
            $jumlahKriteria = count($dataPenilaian[0]) - 2;
            $hasil = [];

            for ($i = 0; $i < $jumlahKriteria; $i++) {
                $kolom = array_column($dataPenilaian, $i + 2);
                if ($jenisKriteria[$i] == 'cost') {
                    $nilaiTerendah = min($kolom);
                    for ($j = 0; $j < $jumlahAlternatif; $j++) {
                        $hasil[$j][$i] = round($nilaiTerendah / $dataPenilaian[$j][$i + 2], 3);
                    }
                } else {
                    $nilaiTertinggi = max($kolom);
                    for ($j = 0; $j < $jumlahAlternatif; $j++) {
                        $hasil[$j][$i] = round($dataPenilaian[$j][$i + 2] / $nilaiTertinggi, 3);
                    }
                }
            }

            foreach ($hasil as $row) {
                $query = "INSERT INTO hasil_normalisasi (C1, C2, C3, C4, C5) 
                  VALUES ('" . implode("', '", $row) . "')";
                mysqli_query($koneksi, $query);
            }
            return mysqli_affected_rows($koneksi);
        }


        // Proses preferensi
        $bobot = Data("SELECT * FROM data_kriteria");

        // Bobot persentase
        $totalBobot = $bobot[0][1] + $bobot[0][2] + $bobot[0][3] + $bobot[0][4] + $bobot[0][5];
        $bobotC1 = $bobot[0][1] / $totalBobot;
        $bobotC2 = $bobot[0][2] / $totalBobot;
        $bobotC3 = $bobot[0][3] / $totalBobot;
        $bobotC4 = $bobot[0][4] / $totalBobot;
        $bobotC5 = $bobot[0][5] / $totalBobot;

        // Jenis kriteria (sesuaikan urutan dengan tabel)
        // C1 = Benefit, C2 = Cost, C3 = Cost, C4 = Benefit, C5 = Benefit
        $jenisKriteria = ['benefit', 'cost', 'cost', 'benefit', 'benefit'];

        // Proses normalisasi
        normalisasi($ambil, $jenisKriteria);

        $hasilNorm = Data("SELECT * FROM hasil_normalisasi");

        function preferensi($hasilNorm, $bobotC1, $bobotC2, $bobotC3, $bobotC4, $bobotC5)
        {
            global $koneksi;
            $alternatif = tampilData("SELECT * FROM data_alternatif");
            foreach ($hasilNorm as $index => $row) {
                if (!isset($alternatif[$index])) continue;
                $ID_Alternatif = $alternatif[$index]['ID_Alternatif'];

                $pre1 = round($bobotC1 * $row[1], 3);
                $pre2 = round($bobotC2 * $row[2], 3);
                $pre3 = round($bobotC3 * $row[3], 3);
                $pre4 = round($bobotC4 * $row[4], 3);
                $pre5 = round($bobotC5 * $row[5], 3);

                $hasilTotal = round($pre1 + $pre2 + $pre3 + $pre4 + $pre5, 3);

                $query = "INSERT INTO hasil_preferensi (C1, C2, C3, C4, C5, Total, ID_Alternatif) 
                  VALUES ('$pre1', '$pre2', '$pre3', '$pre4', '$pre5', '$hasilTotal', '$ID_Alternatif')";
                mysqli_query($koneksi, $query);
            }
            return mysqli_affected_rows($koneksi);
        }
        preferensi($hasilNorm, $bobotC1, $bobotC2, $bobotC3, $bobotC4, $bobotC5);
    }
    header('Location: index.php?page=hasil_perhitungan');
    exit;
}

$hasilNormalisasi = tampilData("SELECT * FROM hasil_normalisasi");

$sqlHasilpref = "SELECT * FROM hasil_preferensi ORDER BY Total DESC";
$hasilPreferensi = tampilData($sqlHasilpref);

if (isset($_POST['reset'])) {
    $sqlNorm = "SELECT COUNT(*) FROM hasil_normalisasi";
    $dataNorm = mysqli_query($koneksi, $sqlNorm);
    $isiNorm = mysqli_fetch_row($dataNorm);

    $sqlPref = "SELECT COUNT(*) FROM hasil_preferensi";
    $dataPref = mysqli_query($koneksi, $sqlPref);
    $isiPref = mysqli_fetch_row($dataPref);

    if ($isiNorm[0] == 0 && $isiPref[0] == 0) {
        echo "<script>
                alert('Tidak Bisa Mereset, Karena Tidak Ada Data Satupun');
             </script>";
    } else {
        $resetNorm = "TRUNCATE TABLE hasil_normalisasi";
        $resetPref = "TRUNCATE TABLE hasil_preferensi";

        mysqli_query($koneksi, $resetNorm);
        mysqli_query($koneksi, $resetPref);

        echo "<script>
                alert('Reset Berhasil');
                document.location.href = 'index.php';
             </script>";
    }
}
