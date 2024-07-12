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

$title = 'Cancel Report';
include 'layout/header.php';

// Memfilter Halaman dengan tanggal
if (isset($_POST['filter'])) {
    $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
    $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");
    $data_barang = select("SELECT * FROM barangcancel WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_cancel DESC");
} else {
    // Ambil semua Data Barang berdasarkan urutan id_barang 
    $data_barang = select("SELECT * FROM barangcancel ORDER BY id_cancel DESC");
    // LIMIT perintah query untuk membatasi jumlah data yang muncul perhalaman
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">LAPORAN BARANG DITOLAK</h1>
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
                                    <h3 class="card-title">Tabel Data Barang Cancel</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#modalFilter"><i class="fas fa-search" aria-hidden="true"></i>&nbsp;Filter Search By Date</button>
                                    <a href="download-excel-barang-cancel.php" style="float: right;" class="btn btn-success ml-3 mb-1"><i class="fas fa-file-excel"></i>&nbsp;Download Excel</a>
                                    <a href="download-pdf-barang-cancel.php" style="float: right;" class="btn btn-warning mb-1"><i class="fas fa-file-pdf"></i>&nbsp;Download PDF</a>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Tanggal</th>
                                                <th>Penerima</th>
                                                <th>Pengirim</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($data_barang as $barang) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $barang['id_barang']; ?></td>
                                                    <td><?= $barang['nama_barang']; ?></td>
                                                    <td><?= $barang['tanggal']; ?></td>
                                                    <td><?= $barang['penerima']; ?></td>
                                                    <td><?= $barang['pengirim']; ?></td>
                                                    <td><?= $barang['jumlah']; ?></td>
                                                    <td><?= $barang['status']; ?></td>
                                                    <td>
                                                        <a href="delete-barang-cancel.php?id_cancel=<?= $barang['id_cancel']; ?>" class="btn btn-danger mb-1" onclick="return confirm('Apakah Anda yakin ingin mengHapus laporan barang ini ?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</a>
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

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-search" aria-hidden="true"></i>&nbsp;Filter Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'layout/footer.php';
?>