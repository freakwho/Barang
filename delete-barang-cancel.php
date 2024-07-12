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
$id_cancel = (int)$_GET['id_cancel'];
if (delete_barangCancel($id_cancel) > 0) {
    echo "<script>
                alert('Data Barang Cancel berhasil dihapus');
                document.location.href = 'barang-cancel.php';
            </script>";
} else {
    echo "<script>
                alert('Data Barang Cancel gagal dihapus');
                document.location.href = 'barang-cancel.php';
            </script>";
}

?>

<?php
include 'layout/footer.php';
?>