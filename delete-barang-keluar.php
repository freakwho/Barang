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


// Menerima id barang keluar yang dipilih pengguna
$id_keluar = (int)$_GET['id_keluar'];
if (delete_barangKeluar($id_keluar) > 0) {
    echo "<script>
                alert('Data Barang keluar berhasil dihapus');
                document.location.href = 'barang-keluar.php';
            </script>";
} else {
    echo "<script>
                alert('Data Barang keluar gagal dihapus');
                document.location.href = 'barang-keluar.php';
            </script>";
}
