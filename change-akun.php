<?php

session_start();

// // Membatasi Halaman sebelum Login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('LOGIN First !!!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = 'Edit Data Akun';
include 'layout/header.php';

// Check apakah data berhasil diubah
if (isset($_POST['ubah'])) {
    if (update_akun($_POST) > 0) {
        echo "<script>
                alert('Data akun berhasil diubah');
                document.location.href = 'akun.php';
            </script>";
    } else {
        echo "<script>
                alert('Data akun gagal diubah');
                document.location.href = 'akun.php';
            </script>";
    }
}



// Ambil ID barang dari URL
$id_user = (int)$_GET['id_user'];

// Query Ambil data barang
$akun = select("SELECT * FROM login WHERE id_user = $id_user")[0];

?>

<div class="container mt-5">
    <h1>Ubah Data Akun</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_user" id="id_user" value="<?= $akun['id_user']; ?>">
        <div class="mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= $akun['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" required><?= $akun['alamat']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= $akun['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password">Password <small>(Masukkan password baru)</small></label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <button type="submit" name="ubah" class="btn btn-primary" style="float: right;">Change</button>
    </form>
</div>

<?php include 'layout/footer.php'; ?>