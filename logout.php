<?php

session_start();

// Membatasi Halaman sebelum Login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('LOGIN First !!!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// kosongkan $_SESSION user login
$_SESSION = [];

session_unset();
session_destroy();
header("Location: login.php");
