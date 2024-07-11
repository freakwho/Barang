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
include 'layout/header.php';


// delete_barangMasuk();
// echo "<script>
//         alert('Report Barang Masuk Berhasil dihapus');
//         document.location.href = 'barang-masuk.php';
//     </script>";

// Menerima id barang masuk yang dipilih pengguna
$id_keluar = (int)$_GET['id_keluar'];
if (cancel_barangKeluar($id_keluar) > 0) {
    echo "<script>
                alert('Barang Keluar berhasil diCancel');
                document.location.href = 'barang-keluar.php';
            </script>";
} else {
    echo "<script>
                alert('Barang Keluar gagal diCancel');
                document.location.href = 'barang-keluar.php';
            </script>";
}

?>

<?php
include 'layout/footer.php';
?>