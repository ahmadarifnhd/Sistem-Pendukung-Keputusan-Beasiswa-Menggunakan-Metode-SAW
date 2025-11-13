<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require '../../config/koneksi_db.php';

function printData($query)
{
	global $koneksi;
	$dataAlter = mysqli_query($koneksi, $query);
	if (!$dataAlter) {
		die("Query error: " . mysqli_error($koneksi));
	}
	$row = [];
	while ($data = mysqli_fetch_assoc($dataAlter)) {
		$row[] = $data;
	}
	return $row;
}

// Ambil data alternatif lengkap
$alternatif = printData("SELECT ID_Alternatif, Nama_Mahasiswa FROM data_alternatif");

// Ambil hasil normalisasi
$printNorm = printData("SELECT * FROM hasil_normalisasi");

// Sinkronisasi Nama Mahasiswa pada hasil normalisasi
foreach ($printNorm as $index => $data) {
	// Jika ID_Alternatif NULL, isi Nama Mahasiswa berdasarkan urutan
	if (empty($data['ID_Alternatif']) || $data['ID_Alternatif'] === null) {
		$printNorm[$index]['Nama_Mahasiswa'] = isset($alternatif[$index]['Nama_Mahasiswa']) ? $alternatif[$index]['Nama_Mahasiswa'] : '-';
	} else {
		$idAlt = $data['ID_Alternatif'];
		$namaMahasiswa = '-';
		foreach ($alternatif as $alt) {
			if ($alt['ID_Alternatif'] == $idAlt) {
				$namaMahasiswa = $alt['Nama_Mahasiswa'];
				break;
			}
		}
		$printNorm[$index]['Nama_Mahasiswa'] = $namaMahasiswa;
	}
}

// Ambil hasil preferensi
$printPrefQuery = "SELECT * FROM hasil_preferensi ORDER BY Total DESC";
$hasilPref = printData($printPrefQuery);

// Sinkronisasi Nama Mahasiswa pada hasil preferensi
foreach ($hasilPref as $index => $data) {
	$idAlt = $data['ID_Alternatif'] ?? null;
	$namaMahasiswa = '-';
	foreach ($alternatif as $alt) {
		if ($alt['ID_Alternatif'] == $idAlt) {
			$namaMahasiswa = $alt['Nama_Mahasiswa'];
			break;
		}
	}
	$hasilPref[$index]['Nama_Mahasiswa'] = $namaMahasiswa;
}

$mpdf = new \Mpdf\Mpdf();

// path file gambar
$imgPath = realpath(__DIR__ . '/../../img/genbi.png');

$imgTag = '';
if ($imgPath && is_file($imgPath) && is_readable($imgPath)) {
	$mpdf->Image($imgPath, 80, 10, 40);
} else {
	// fallback: coba data URI (jika file bisa dibaca)
	if ($imgPath && is_file($imgPath)) {
		$data = @file_get_contents($imgPath);
		if ($data !== false) {
			$imgData = base64_encode($data);
			$imgTag = '<img src="data:image/png;base64,' . $imgData . '" style="height:120px; margin-bottom:10px;" />';
		}
	}
}

// buat header tanpa mengandalkan path filesystem lagi (jika Image() dipakai, img akan sudah ditulis)
$headerTitle = '<div style="text-align: center;">'
	. $imgTag .
	'<h1 style="font-size: 22px; text-align: center;">
	<i>Sistem Pendukung Keputusan Beasiswa GenBI <br> (SAW Method)</i></h1>
	<hr style="color: black; border: none; margin-top: -6px;">
</div>';

$waktu = '<p style="margin-top: -3px;"><i>' . date("D, j F Y") . '</i></p>';

$header1 = '<div>
    		      <h2 style="font-size: 16px; text-align: center; margin-top: 5px;">Hasil Normalisasi</h2>
    		   </div>';

$tabel1 = '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: center; font-size: 13px; 
   	margin-top: -5px;">
              <thead>
                <tr class="text-center">
                  <th>Nama Mahasiswa</th>
                  <th>C1</th>
                  <th>C2</th>
                  <th>C3</th>
                  <th>C4</th>
				  <th>C5</th>
                </tr>
              </thead>
              <tbody>';
$no1 = 1;
foreach ($printNorm as $data1) {
	$tabel1 .= '<tr>
<td>' . $data1['Nama_Mahasiswa'] . '</td>
<td>' . $data1['C1'] . '</td>
<td>' . $data1['C2'] . '</td>
<td>' . $data1['C3'] . '</td>
<td>' . $data1['C4'] . '</td>
<td>' . $data1['C5'] . '</td>
</tr>';
	$no1++;
}
$tabel1 .= '</tbody>
			            	</table>';

$header2 = '<div>
	<h2 style="font-size: 16px; text-align: center; margin-top: 26px;">Hasil Preferensi</h2>
</div>';

$tabel2 = '<table border="1" cellspacing="0" cellpadding="5" 
	style="width: 100%; table-layout: fixed; text-align: center; font-size: 13px; margin-top: -5px;">
	<thead>
		<tr class="text-center">
			<th style="width:5%;">Urutan</th>
			<th style="width:25%;">Nama Mahasiswa</th>
			<th style="width:10%;">C1</th>
			<th style="width:10%;">C2</th>
			<th style="width:10%;">C3</th>
			<th style="width:10%;">C4</th>
			<th style="width:10%;">C5</th>
			<th style="width:10%;">Total</th>
		</tr>
	</thead>
	<tbody>';

$no2 = 1;
foreach ($hasilPref as $data2) {
	$isTop = $no2 <= 3; // baris 1-3 = lolos -> beri warna hijau
	$rowStyle = $isTop ? 'background-color:#ffffff;color:#ffffff;' : ''; //bg color awal #28a745
	// pastikan teks nama & nilai aman untuk output PDF
	$nama = htmlspecialchars($data2['Nama_Mahasiswa']);
	$c1 = htmlspecialchars($data2['C1']);
	$c2 = htmlspecialchars($data2['C2']);
	$c3 = htmlspecialchars($data2['C3']);
	$c4 = htmlspecialchars($data2['C4']);
	$c5 = htmlspecialchars($data2['C5']);
	$total = htmlspecialchars($data2['Total']);

	$tabel2 .= '<tr style="' . $rowStyle . '">
        <td style="width:5%; text-align:center;">' . $no2 . '</td>
        <td style="width:25%; text-align:center;">' . $nama . '</td>
        <td style="width:10%; text-align:center;">' . $c1 . '</td>
        <td style="width:10%; text-align:center;">' . $c2 . '</td>
        <td style="width:10%; text-align:center;">' . $c3 . '</td>
        <td style="width:10%; text-align:center;">' . $c4 . '</td>
        <td style="width:10%; text-align:center;">' . $c5 . '</td>
        <td style="width:10%; text-align:center;">' . $total . '</td>
    </tr>';
	$no2++;
}

$tabel2 .= '</tbody></table>';

function hasilTertinggi($query)
{
	global $koneksi;
	$dataAlter = mysqli_query($koneksi, $query);
	if (!$dataAlter) {
		die("Query error: " . mysqli_error($koneksi));
	}
	$row = [];
	while ($data = mysqli_fetch_row($dataAlter)) {
		$row[] = $data;
	}
	return $row;
}

$nilai = hasilTertinggi("SELECT MAX(Total) AS Total FROM hasil_preferensi");
$hasil = $nilai[0][0];

// Nama Mahasiswa dengan nilai tertinggi (peringkat 1 -3)
$rank_01 = $hasilPref[0]['Nama_Mahasiswa'] ?? '-';
$rank_02 = $hasilPref[1]['Nama_Mahasiswa'] ?? '-';
$rank_03 = $hasilPref[2]['Nama_Mahasiswa'] ?? '-';

$kesimpulan = "<p style=\"margin-top: 23px; line-height: 22px; text-align: justify;\"><i>
Berdasarkan jumlah alternatif, nilai bobot setiap kriteria, serta penilaian yang dilakukan, 
hasil pemilihan mahasiswa yang layak menerima Beasiswa GENBI dengan metode SAW merekomendasikan nama-nama mahasiswa penerima Beasiswa GENBI, 
yaitu <b>{$rank_01}</b>, <b>{$rank_02}</b>, dan <b>{$rank_03}</b></b>.</i></p>";

$mpdf->WriteHTML($headerTitle);
$mpdf->WriteHTML($waktu);
$mpdf->WriteHTML($header1);
$mpdf->WriteHTML($tabel1);
$mpdf->WriteHTML($header2);
$mpdf->WriteHTML($tabel2);
$mpdf->WriteHTML($kesimpulan);

$mpdf->Output('SPK_Hasil_Keputusan.pdf', \Mpdf\Output\Destination::INLINE);
