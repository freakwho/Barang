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

$title = 'Hapus Data Barang';
include 'config/app.php';


delete_barangKeluar();
echo "<script>
        alert('Report Barang Keluar Berhasil dihapus');
        document.location.href = 'barang-keluar.php';
    </script>";
