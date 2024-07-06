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

$title = 'Detail Akun';
include 'layout/header.php';

// Mengambil id akun dari URL
$id_user = (int)$_GET['id_user'];

// menampilkan data akun
$user = select("SELECT * FROM login WHERE id_user = $id_user")[0];

?>

<div class="container mt-5">
    <h1><?= $user['nama']; ?></h1>
    <table class="table table-bordered table-striped mt-3">
        <tr>
            <td>Alamat</td>
            <td>: <?= $user['alamat']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>: <?= $user['email']; ?></td>
        </tr>
        <tr>
            <td>Hak Akses</td>
            <td>: <?= $user['level']; ?></td>
        </tr>
    </table>
    <a href="akun.php" class="btn btn-secondary btn-sm" style="float:right;">Kembali</a>
</div>

<?php include 'layout/footer.php'; ?>