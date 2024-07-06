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

// Membatasi Halaman sesuai user login
// if ($_SESSION['level'] != 2) {
//     echo "<script>
//               alert('Perhatioan anda tidak punya hak akses');
//               document.location.href = 'index.php';
//             </script>";
//     exit;
// }

$title = 'Data Akun';
include 'layout/header.php';

$data_akun = select("SELECT * FROM login ORDER BY id_user ASC");

//  Jika Tombol Tambah di tekan maka script berikut berkerja
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun berhasil ditambahkan');
                document.location.href = 'akun.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Akun gagal ditambahkan');
                document.location.href = 'akun.php';
            </script>";
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">DATA AKUN</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tabel Data Akun</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#modalAkun"><i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;Tambah Akun</button>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Hak Akses</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($data_akun as $akun) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $akun['nama']; ?></td>
                                                    <td><?= $akun['email']; ?></td>
                                                    <td>Password TerEnkripsi</td>
                                                    <td><?= $akun['level']; ?></td>
                                                    <td class="text-center" width="27%">
                                                        <a href="detail-akun.php?id_user=<?= $akun['id_user']; ?>" class="btn btn-info mb-1"><i class="fas fa-info"></i>&nbsp;Detail</a>
                                                        <a href="change-akun.php?id_user=<?= $akun['id_user']; ?>" class="btn btn-success mb-1"><i class="fas fa-pencil-alt"></i>&nbsp;Change</a>
                                                        <a href="delete-akun.php?id_user=<?= $akun['id_user']; ?>" class="btn btn-danger mb-1" onclick="return confirm('yakin ?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalAkun" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <input type="hidden" name="level" id="level" value="Admin">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'layout/footer.php';
?>