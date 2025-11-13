<?php
require 'config/koneksi_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Validasi password
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Password dan konfirmasi password tidak cocok!');
                window.location.href='index.php?page=add_user';
              </script>";
        exit;
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $query = "INSERT INTO data_user (npm, username, password, role) 
              VALUES ('$npm', '$username', '$password_hash', '$role')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('User berhasil ditambahkan!');
                window.location.href='index.php?page=list_user';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>