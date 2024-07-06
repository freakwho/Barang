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

$title = 'Hapus Data Akun';
include 'config/app.php';

// Menerima id mahasiswa yang dipilih pengguna
$id_user = (int)$_GET['id_user'];
if (delete_akun($id_user) > 0) {
    echo "<script>
                alert('Data Akun berhasil dihapus');
                document.location.href = 'akun.php';
            </script>";
} else {
    echo "<script>
                alert('Data Akun gagal dihapus');
                document.location.href = 'akun.php';
            </script>";
}
