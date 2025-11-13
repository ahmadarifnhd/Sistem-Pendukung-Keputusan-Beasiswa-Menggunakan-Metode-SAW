<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Hapus cookie
setcookie('ID', '', time() - 3600, "/");
setcookie('Key', '', time() - 3600, "/");

header('Location: login.php');
exit;
?>