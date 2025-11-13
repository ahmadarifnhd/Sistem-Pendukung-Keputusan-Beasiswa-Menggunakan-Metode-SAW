<?php
require 'koneksi_db.php';
error_reporting(error_reporting() & ~E_NOTICE);

// Ambil nilai `page` dengan pengecekan
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';

switch ($page) {
	// halaman alternatif
	case 'data_alternatif':
		require 'pages/alternatif/alternatif.php';
		break;
	// hapus data alter
	case 'delete_alter':
		require 'pages/alternatif/proses_hapus_alter.php';
		break;
	// edit data alter
	case 'edit_alter':
		require 'pages/alternatif/proses_update_alter.php';
		break;
	// ====================================================

	// halaman kriteria
	case 'data_kriteria':
		require 'pages/kriteria/kriteria.php';
		break;
	// hapus data bobot kriteria
	case 'delete_kriteria':
		require 'pages/kriteria/proses_hapus_kriteria.php';
		break;
	// ====================================================

	// halaman penilaian
	case 'data_penilaian':
		require 'pages/penilaian/penilaian.php';
		break;
	// hapus data penilaian
	case 'delete_penilaian':
		require 'pages/penilaian/proses_hapus_penilaian.php';
		break;
	// edit data penilaian
	case 'edit_penilaian':
		require 'pages/penilaian/proses_update_penilaian.php';
		break;
	// ====================================================

	// halaman perhitungan
	case 'perhitungan':
		require 'pages/perhitungan/perhitungan.php';
		break;
	// ====================================================

	// halaman hasil
	case 'hasil_perhitungan':
		require 'pages/hasil/hasil_perhitungan.php';
		break;

	// jika ada request ke nama lama, arahkan ke hasil_perhitungan
	case 'hasil_normalisasi':
	case 'hasil_preferensi':
		require 'pages/hasil/hasil_perhitungan.php';
		break;
	// ====================================================

	// halaman user
	case 'list_user':
		require 'pages/user/list_user.php';
		break;
	case 'add_user':
		require 'pages/user/add_user.php';
		break;
	case 'proses_add_user':
		require 'pages/user/proses_add_user.php';
		break;
	case 'edit_user':
		require 'pages/user/edit_user.php';
		break;
	case 'proses_update_user':
		require 'pages/user/proses_update_user.php';
		break;
	case 'delete_user':
		require 'pages/user/proses_hapus_user.php';
		break;
	case 'edit_profile':
		require 'pages/user/edit_profile.php';
		break;
	// ====================================================
	// halaman upberkas
	case 'upload_berkas':
		require 'pages/upberkas/upload_berkas.php';
		break;
	case 'list_berkas':
		require 'pages/upberkas/list_berkas.php';
		break;
	case 'list_berkas2':
		require 'pages/upberkas/list_berkas2.php';
		break;
	case 'edit_berkas':
		require 'pages/upberkas/edit_berkas.php';
		break;
	case 'hapus_berkas':
		require 'pages/upberkas/hapus_berkas.php';
		break;

	// ====================================================
	// halaman tentang
	case 'tentang':
		require 'tentang.php';
		break;
	// ====================================================

	// halaman cara penggunaan
	case 'petunjuk':
		require 'cara_penggunaan.php';
		break;
	// ====================================================

	// halaman beranda (default)
	default:
		// Cari file beranda di beberapa lokasi umum dan gunakan yang ada.
		$base = __DIR__ . '/../';
		if (file_exists($base . 'pages/beranda/beranda.php')) {
			require $base . 'pages/beranda/beranda.php';
		} elseif (file_exists($base . 'pages/beranda.php')) {
			require $base . 'pages/beranda.php';
		} elseif (file_exists($base . 'beranda.php')) {
			require $base . 'beranda.php';
		} else {
			// Fallback ringan agar halaman tidak menyebabkan fatal error.
			echo '<section class="content"><div class="container-fluid"><h1>Beranda tidak ditemukan</h1><p>File beranda tidak ada di lokasi yang diharapkan. Periksa: pages/beranda/beranda.php atau beranda.php</p></div></section>';
		}
		break;
}
