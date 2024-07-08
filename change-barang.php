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

$title = 'Edit Barang';
include 'layout/header.php';

// Check apakah data berhasil diubah
if (isset($_POST['ubah'])) {
    if (update_barang($_POST) > 0) {
        echo "<script>
                alert('Data barang berhasil diubah');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data barang gagal diubah');
                document.location.href = 'index.php';
            </script>";
    }
}

// Ambil ID barang dari URL
$id_barang = (int)$_GET['id_barang'];

// Query Ambil data barang
$barang = select("SELECT * FROM stock WHERE id_barang = $id_barang")[0];

?>

<div class="container mt-5">
    <h1>Ubah Data Barang</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?= $barang['id_barang']; ?>">
        <input type="hidden" name="fotoLama" value="<?= $barang['foto']; ?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama barang..." required value="<?= $barang['nama']; ?>">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="alamat"><?= $barang['deskripsi']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Barang per Unit</label>
            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga Barang..." required value="<?= $barang['harga']; ?>">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Barang</label>
            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto Barang..." onchange="PreviewImg()">
            <img src="" alt="" class="img-thumbnail img-preview mt-3" width="100px">
            <p>
                <small>Gambar Sebelumnya</small>
            </p>
            <img src="assets/img/<?= $barang['foto']; ?>" alt="foto" width="100px">
        </div>
        <button type="submit" name="ubah" class="btn btn-primary" style="float: right;">Change</button>
    </form>
</div>

<!-- Preview Image -->
<script>
    function PreviewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?php include 'layout/footer.php'; ?>