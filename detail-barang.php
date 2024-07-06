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

$title = 'Detail Barang';
include 'layout/header.php';

// Mengambil id barang dari URL
$id_barang = (int)$_GET['id_barang'];

// menampilkan data barang
$barang = select("SELECT * FROM stock WHERE id_barang = $id_barang")[0];

?>

<div class="container mt-5">
    <h1><?= $barang['nama']; ?></h1>
    <table class="table table-bordered table-striped mt-3">
        <tr>
            <a href="assets/img/<?= $barang['foto']; ?>">
                <img src="assets/img/<?= $barang['foto']; ?>" alt="foto" width="30%">
            </a>
        </tr>
        <tr>
            <td>ID Barang</td>
            <td>: <?= $barang['id_barang']; ?></td>
        </tr>
        <tr>
            <td>Harga per Unit</td>
            <td>: <?= $barang['harga']; ?></td>
        </tr>
        <tr>
            <td>Stock</td>
            <td>: <?= $barang['stock']; ?></td>
        </tr>
        <tr>
            <td>Barcode</td>
            <td class="text-center">
                <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
            </td>
        </tr>
        <tr>
            <td>
                <p><?= $barang['deskripsi']; ?></p>
            </td>
        </tr>
    </table>
    <a href="index.php" class="btn btn-secondary btn-sm" style="float:right;">Kembali</a>
</div>

<?php include 'layout/footer.php'; ?>