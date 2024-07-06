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

delete_barangMasuk();
echo "<script>
        alert('Report Barang Masuk Berhasil dihapus');
        document.location.href = 'barang-masuk.php';
    </script>";

?>

<?php
include 'layout/footer.php';
?>