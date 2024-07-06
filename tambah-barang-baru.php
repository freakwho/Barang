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

$title = 'Tambah Data Barang';
include 'layout/header.php';

// Check apakah data berhasil ditambah
if (isset($_POST['tambah'])) {
    if (create_barang($_POST) > 0) {
        echo "<script>
                alert('Data barang berhasil ditambah');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data barang gagal ditambah');
                document.location.href = 'tambah-barang-baru.php';
            </script>";
    }
}

?>

<div class="container mt-5">
    <h1>Tambah Stock Barang Baru</h1>

    <form action="#" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="alamat"></textarea>
        </div>
        <div class="mb-3">
            <label for="harga">Harga Barang per Unit</label>
            <input type="text" name="harga" id="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="pengirim">Pengirim</label>
            <input type="text" name="pengirim" id="pengirim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="stock">Jumlah</label>
            <input type="number" name="stock" id="stock" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <input type="hidden" name="status" value="Barang Masuk">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto..." onchange="PreviewImg()">

            <img src="" alt="" class="img-thumbnail img-preview mt-3" width="100px">
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
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
    </form>
</div>

<?php include 'layout/footer.php'; ?>