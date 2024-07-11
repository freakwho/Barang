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
$id_masuk = (int)$_GET['id_masuk'];
if (cancel_barangMasuk($id_masuk) > 0) {
    echo "<script>
                alert('Barang Masuk berhasil diCancel');
                document.location.href = 'barang-masuk.php';
            </script>";
} else {
    echo "<script>
                alert('Barang Masuk gagal diCancel');
                document.location.href = 'barang-masuk.php';
            </script>";
}

?>

<?php
include 'layout/footer.php';
?>