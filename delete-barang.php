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

// Menerima id barang yang dipilih pengguna
$id_barang = (int)$_GET['id_barang'];
if (delete_barang($id_barang) > 0) {
    echo "<script>
                alert('Data Barang berhasil dihapus');
                document.location.href = 'index.php';
            </script>";
} else {
    echo "<script>
                alert('Data Barang gagal dihapus');
                document.location.href = 'index.php';
            </script>";
}
