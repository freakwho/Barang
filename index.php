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

$title = 'Data Barang';
include 'layout/header.php';

if (isset($_POST['tambah'])) {
  if (create_barangMasuk($_POST) > 0 && !$updatestock) {
    echo "<script>
            alert('Data Barang Masuk berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>";
  } else {
    echo "<script>
            alert('Data Barang Masuk gagal ditambahkan');
            document.location.href = 'index.php';
        </script>";
  }
}

if (isset($_POST['kurang'])) {
  if (create_barangKeluar($_POST) > 0 && !$updatestock) {
    echo "<script>
            alert('Data Barang Berhasil di Check Out');
            document.location.href = 'index.php';
        </script>";
  } else {
    echo "<script>
            alert('Data Barang Gagal di Check Out');
            document.location.href = 'index.php';
        </script>";
  }
}

$data_barang = select("SELECT * FROM stock ORDER BY id_barang DESC");


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">DATA BARANG</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <a href="download-excel-barang.php" class="btn btn-success ml-3 mb-1"><i class="fas fa-file-excel"></i>&nbsp;Download Excel</a>
      <a href="download-pdf-barang.php" class="btn btn-warning mb-1"><i class="fas fa-file-pdf"></i>&nbsp;Download PDF</a>
      <button type="button" class="btn btn-danger mr-3 mb-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#modalKurang"><i class="fas fa-minus-circle" aria-hidden="true"></i>&nbsp;Check Out Barang</button>
      <button type="button" class="btn btn-primary mr-3 mb-1" style="float: right;" data-bs-toggle="modal" data-bs-target="#modalCheckIn"><i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;Check In Barang</button>
      <!-- /.row -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">

                <!-- Alert / Pesan jika stock Barang sudah Habis  -->
                <?php
                $ambilDataStock = mysqli_query($db, "select * from stock where stock < 1");
                while ($fetch = mysqli_fetch_array($ambilDataStock)) {
                  $namaBarang = $fetch['nama'];
                ?>
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Perhatian !</strong> Stock Barang <?= $namaBarang; ?> Telah Habis
                  </div>
                <?php
                }
                ?>

                <!-- .card-header -->
                <div class="card-body">
                  <table id="example3" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID Barang</th>
                        <th>Nama</th>
                        <th>Harga Per Unit</th>
                        <th>Stock</th>
                        <th>Harga Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; ?>
                      <?php foreach ($data_barang as $barang) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $barang['id_barang']; ?></td>
                          <td><?= $barang['nama']; ?></td>
                          <?php
                          $ambilDataHarga = $barang['harga'];
                          $amiblDataStock = $barang['stock'];
                          $hargaTotal = $ambilDataHarga * $amiblDataStock;
                          ?>
                          <td>Rp. <?= number_format($barang['harga'], 2, ',', '.'); ?></td>
                          <td><?= $barang['stock']; ?></td>
                          <td>Rp. <?= number_format($hargaTotal, 2, ',', '.'); ?></td>
                          <td class="text-center" width="27%">
                            <a href="detail-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-info mb-1"><i class="fas fa-info"></i>&nbsp;Detail</a>
                            <a href="change-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success mb-1"><i class="fas fa-pencil-alt"></i>&nbsp;Change</a>
                            <a href="delete-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger mb-1" onclick="return confirm('yakin ?');"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</a>
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
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Stock Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="baranglama">Pilih Barang :</label>
            <select name="baranglama" id="baranglama" class="form-control">
              <?php
              $ambilData = mysqli_query($db, "select * from stock");
              while ($fetcharray = mysqli_fetch_array($ambilData)) {
                $namabarang = $fetcharray['nama'];
                $idbarang = $fetcharray['id_barang'];
              ?>
                <option value="<?= $idbarang; ?>"><?= $namabarang; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="pengirim">Pengirim</label>
            <input type="text" name="pengirim" id="pengirim" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
          </div>
          <div class="mb-3">
            <label for="status">Status :</label>
            <select name="status" id="status" class="form-control">
              <option value="Barang Masuk">In</option>
              <option value="Retur ke Gudang">Return</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Kurang -->
<div class="modal fade" id="modalKurang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="exampleModalLabel">Check Out Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="baranglama">Pilih Barang :</label>
            <select name="baranglama" id="baranglama" class="form-control">
              <?php
              $ambilData = mysqli_query($db, "select * from stock");
              while ($fetcharray = mysqli_fetch_array($ambilData)) {
                $namabarang = $fetcharray['nama'];
                $idbarang = $fetcharray['id_barang'];
              ?>
                <option value="<?= $idbarang; ?>"><?= $namabarang; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="penerima">Penerima</label>
            <input type="text" name="penerima" id="penerima" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
          </div>
          <div class="mb-3">
            <label for="status">Status :</label>
            <select name="status" id="status" class="form-control">
              <option value="Barang Keluar">Out</option>
              <option value="Retur ke Pengirim">Return</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" name="kurang" class="btn btn-danger">CheckOut</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Check In Barang -->
<div class="modal fade" id="modalCheckIn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Stock Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary mr-3 mb-1" data-bs-dismiss="modal" style="float: right;" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;Masuk Barang Lama</button>
        <a href="tambah-barang-baru.php" class="btn btn-primary mr-3 mb-1" aria-hidden="true">
          <i class="nav-icon fa fa-plus-square"></i>&nbsp;Masuk Barang Baru
        </a>
      </div>
    </div>
  </div>
</div>

<?php
include 'layout/footer.php';
?>