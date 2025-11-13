<?php
require 'config/koneksi_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Bisa kosong
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Cek apakah ingin ganti password
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE data_user 
                  SET npm='$npm', username='$username', password='$password_hash', role='$role' 
                  WHERE id='$id'";
    } else {
        $query = "UPDATE data_user 
                  SET npm='$npm', username='$username', role='$role' 
                  WHERE id='$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('User berhasil diupdate!');
                window.location.href='index.php?page=list_user';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>