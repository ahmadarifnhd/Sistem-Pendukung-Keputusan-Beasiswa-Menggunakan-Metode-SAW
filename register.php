<?php
require 'config/koneksi_db.php';
session_start();

// Jika sudah login, redirect
if (isset($_SESSION['masuk'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['user']));
    $password = $_POST['password'];
    $confirmPass = $_POST['confirm'];
    $role = 'user'; // default role

    // Cek username sudah dipakai
    $cekUser = mysqli_query($koneksi, "SELECT username FROM data_user WHERE username = '$username'");
    if (mysqli_fetch_assoc($cekUser)) {
        echo "<script>
                alert('Username Telah Terpakai');
                document.location.href = 'register.php';
              </script>";
        exit;
    }

    // Cek password match
    if ($password !== $confirmPass) {
        echo "<script>
                alert('Mohon Cek Kembali Password Anda');
                document.location.href = 'register.php';
              </script>";
        exit;
    }

    // Hash password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan ke database
    $sql = "INSERT INTO data_user (username, password, role) VALUES ('$username', '$password_hashed', '$role')";
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Register Berhasil');
                document.location.href = 'login.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Terjadi kesalahan: " . mysqli_error($koneksi) . "');
              </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK BEASISWA GENBI | Mendaftar</title>

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="192x192" href="img/genbi.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

    <style>
        .btn-primary {
            background-color: #0c2461;
            border-color: #0c2461;
        }

        .btn-primary:hover {
            background-color: green;
            border-color: green;
        }

        a {
            color: #0c2461;
        }

        .register-logo a {
            font-size: 30px;
        }

        .register-card-body {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .register-box {
            width: 800px;
        }

        .register-image {
            max-width: 400px;
            height: 400px;
        }

        .register-form {
            flex: 1;
            padding: 20px;
        }

        .register-img {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f6f9;
        }

        .card {
            background-color: #333;
        }

        .input-group-text {
            background-color: #555;
            border-color: #555;
        }

        .form-control {
            background-color: #444;
            border-color: #444;
            color: #fff;
        }
    </style>
</head>

<body class="hold-transition register-page" style="background-color:#0c2461 ">
    <div class="register-box">
        <div class="register-logo">
            <a href="register.php" style="color : #fff;">SISTEM PEDUKUNG KEPUTUSAN BEASISWA GENBI METODE SAW</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <div class="register-img">
                    <img src="img\genbi.png" class="register-image">
                </div>
                <div class="register-form">
                    <p class="login-box-msg">Daftar Pengguna Baru</p>

                    <form method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="user" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm"
                                required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block" name="register"><i
                                        class="fas fa-sign-in-alt"></i> Register</button>
                            </div>
                        </div>
                    </form>

                    <a href="login.php" class="text-center">Sudah Mendaftar Akun</a>
                </div>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>

</html>