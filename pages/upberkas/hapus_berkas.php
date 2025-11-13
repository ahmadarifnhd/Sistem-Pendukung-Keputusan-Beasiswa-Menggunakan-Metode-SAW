<?php
require 'config/koneksi_db.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM tbl_berkas WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

// Hapus file dari folder
if (file_exists($row['file_aktif_organisasi'])) unlink($row['file_aktif_organisasi']);
if (file_exists($row['file_tidak_beasiswa'])) unlink($row['file_tidak_beasiswa']);
if (file_exists($row['file_keluarga_tidak_mampu'])) unlink($row['file_keluarga_tidak_mampu']);
if (file_exists($row['file_ipk'])) unlink($row['file_ipk']);

// Hapus dari database
mysqli_query($koneksi, "DELETE FROM tbl_berkas WHERE id='$id'");

echo "<script>alert('Data berhasil dihapus!'); window.location='index.php?page=list_berkas';</script>";