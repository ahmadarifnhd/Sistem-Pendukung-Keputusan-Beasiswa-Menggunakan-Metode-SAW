<?php
require 'config/koneksi_db.php';

$id = $_GET['id'];
$hapus = mysqli_query($koneksi, "DELETE FROM data_user WHERE id='$id'");

if($hapus){
    echo "<script>
            alert('User berhasil dihapus');
            window.location.href='index.php?page=list_user';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus user');
            window.location.href='index.php?page=list_user';
          </script>";
}
?>