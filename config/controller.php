<?php

// Fungsi Menampilkan
function select($query)
{

    // Panggil Koneksi Database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Fungsi Menambahkan data Barang
function create_barang($post)
{
    global $db;

    $nama       = strip_tags($post['nama']);
    $deskripsi  = strip_tags($post['deskripsi']);
    $harga      = strip_tags($post['harga']);
    $pengirim   = strip_tags($post['pengirim']);
    $stock      = strip_tags($post['stock']);
    $status     = strip_tags($post['status']);
    $barcode    = rand(100000, 999999);
    $foto       = upload_file();

    $ceknama  = mysqli_query($db, "select nama from stock where nama='$nama'");
    $count = mysqli_num_rows($ceknama);

    // Validasi variabel nama already exist
    if ($count != 0) {
        echo '<script>
            alert("Nama Barang sudah terdaftar, Silahkan input nama barang yang lain");
            window.location.href="tambah-barang-baru.php"
        </script>';
    }

    // Validasi Upload File
    if (!$foto) {
        return false;
    }

    // Query Tambah Data ke Tabel stock
    $query = "INSERT INTO stock VALUES(null, '$nama', '$deskripsi', '$harga', '$stock', '$barcode', '$foto')";
    mysqli_query($db, $query);

    // Ambil ID Barang dari tabel Stock
    $cekid = mysqli_query($db, "select * from stock where nama='$nama'");
    $ambilid = mysqli_fetch_array($cekid);

    $idsekar = $ambilid['id_barang'];

    // Query Tambah Data ke Tabel barangmasuk
    $quero = "INSERT INTO barangmasuk VALUES(null, '$idsekar', '$nama', CURRENT_TIMESTAMP(), '$pengirim', '$stock', '$status')";
    mysqli_query($db, $quero);

    return mysqli_affected_rows($db);
}

// Fungsi Mengubah data barang
function update_barang($post)
{
    global $db;

    $id_barang  = $post['id_barang'];
    $nama       = strip_tags($post['nama']);
    $deskripsi  = strip_tags($post['deskripsi']);
    $harga      = strip_tags($post['harga']);
    $fotoLama   = strip_tags($post['fotoLama']);

    // Validasi Upload File
    if ($_FILES['foto']['error'] == 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload_file();
    }

    // query ubah data
    $query = "UPDATE stock SET nama = '$nama', deskripsi = '$deskripsi', harga = '$harga', foto = '$foto' WHERE id_barang = $id_barang";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Menghapus data barang
function delete_barang($id_barang)
{
    global $db;

    // Query Menghapus data barang
    $query = "DELETE FROM stock WHERE id_barang = $id_barang";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Menambahkan Stock Barang yang sudah ada
function create_barangMasuk($post)
{
    global $db;

    $baranglama = strip_tags($post['baranglama']);
    $pengirim  = strip_tags($post['pengirim']);
    $jumlah  = strip_tags($post['jumlah']);
    $status  = strip_tags($post['status']);

    $cekstock = mysqli_query($db, "select * from stock where id_barang='$baranglama'");
    $ambildata = mysqli_fetch_array($cekstock);

    $stocksekar = $ambildata['stock'];
    $namasekar = $ambildata['nama'];
    $tambahstock = $stocksekar + $jumlah;

    // query tambah data
    $query = "INSERT INTO barangmasuk VALUES(null, '$baranglama', '$namasekar', CURRENT_TIMESTAMP(), '$pengirim', '$jumlah', '$status')";

    $updatestock = mysqli_query($db, "update stock set stock='$tambahstock' where id_barang='$baranglama'");

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Mengeluarkan Barang / Mengurangi Jumlah Stock barang
function create_barangKeluar($post)
{
    global $db;

    $baranglama = strip_tags($post['baranglama']);
    $penerima   = strip_tags($post['penerima']);
    $jumlah     = strip_tags($post['jumlah']);
    $status  = strip_tags($post['status']);

    $cekstock  = mysqli_query($db, "select * from stock where id_barang='$baranglama'");
    $ambildata = mysqli_fetch_array($cekstock);

    $stocksekar = $ambildata['stock'];
    $namasekar = $ambildata['nama'];

    if ($stocksekar >= $jumlah) {

        $tambahstock = $stocksekar - $jumlah;
        // query tambah data
        $query = "INSERT INTO barangkeluar VALUES(null, '$baranglama', '$namasekar', CURRENT_TIMESTAMP(), '$penerima', '$jumlah', '$status')";

        $updatestock = mysqli_query($db, "update stock set stock='$tambahstock' where id_barang='$baranglama'");

        mysqli_query($db, $query);
        return mysqli_affected_rows($db);
    } else {
        echo '<script>
            alert("Stock Saat ini tidak mencukupi");
            window.location.href="index.php"
        </script>';
    }
}

// Fungsi Upload File Foto atau Gambar
function upload_file()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Check File yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    // explode . $namaFile => Memberi Extensi Format
    $extensifile      = explode('.', $namaFile);
    // Mengkonversi huruf Extensi File menjadi huruf kecil semua
    $extensifile      = strtolower(end($extensifile));

    // Cek extensi file
    if (!in_array($extensifile, $extensifileValid)) {
        // pesan gagal
        echo "<script>
                alerts('Format File Salah');
                document.location.href = 'tambah-mahasiswa.php';        
            </script>";
        die();
    }

    // Cek Ukuran File
    if ($ukuranFile > 2048000) {
        // pesan gagal
        echo "<script>
                alerts('Ukuran File Max 2 MB');
                document.location.href = 'tambah-mahasiswa.php';        
            </script>";
        die();
    }

    // Generate Nama File Baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // Pindahkan file upload ke folder lokal
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

// Fungsi Menambahkan Akun
function create_akun($post)
{
    global $db;

    // strip_tags dan htmlspecialchars berfungsi untuk mengamankan dari injeksi input
    $nama       = strip_tags($post['nama']);
    $alamat     = strip_tags($post['alamat']);
    $email      = strip_tags($post['email']);
    $password   = strip_tags($post['password']);
    $level      = strip_tags($post['level']);

    // query tambah data
    $query = "INSERT INTO login VALUES(null, '$nama', '$alamat', '$email', '$password', '$level')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi menghapus data akun
function delete_akun($id_user)
{
    global $db;

    // Query Menghapus data akun
    $query = "DELETE FROM login WHERE id_user = $id_user";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi mengubah data akun
function update_akun($post)
{
    global $db;

    $id_user    = strip_tags($post['id_user']);
    $nama       = strip_tags($post['nama']);
    $alamat     = strip_tags($post['alamat']);
    $email      = strip_tags($post['email']);
    $password   = strip_tags($post['password']);

    // query ubah data
    $query = "UPDATE login SET nama = '$nama', alamat = '$alamat', email = '$email' , password = '$password' WHERE id_user = $id_user";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Menghapus Record barang keluar
function delete_barangKeluar($id_keluar)
{
    global $db;

    // Query Menghapus data barang
    // Query Menghapus data barang
    $query = "DELETE FROM barangkeluar WHERE id_keluar = $id_keluar";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Menghapus Record barang masuk
function delete_barangMasuk($id_masuk)
{
    global $db;

    // Query Menghapus data barang
    $query = "DELETE FROM barangmasuk WHERE id_masuk = $id_masuk";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Fungsi Membatalkan Aksi barang masuk
function cancel_barangMasuk($id_masuk)
{
    global $db;

    $cekid_masuk = mysqli_query($db, "select * from barangmasuk where id_masuk='$id_masuk'");
    $ambildata = mysqli_fetch_array($cekid_masuk);

    $id_barang = $ambildata['id_barang'];
    $jumlahMasuk = $ambildata['jumlah'];

    $cekid_barang = mysqli_query($db, "select * from stock where id_barang='$id_barang'");
    $ambilStock = mysqli_fetch_array($cekid_barang);

    $stockSekar = $ambilStock['stock'];

    $kurangStock = $stockSekar - $jumlahMasuk;

    // Query Mengupdate stock barang setelah barang masuk di Cancel
    $updatestock = "UPDATE stock SET stock='$kurangStock' WHERE id_barang='$id_barang'";
    mysqli_query($db, $updatestock);


    // Query Menghapus data barang masuk
    $query = "DELETE FROM barangmasuk WHERE id_masuk = $id_masuk";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// Fungsi Membatalkan Aksi barang keluar
function cancel_barangKeluar($id_keluar)
{
    global $db;

    $cekid_keluar = mysqli_query($db, "select * from barangkeluar where id_keluar='$id_keluar'");
    $ambildata = mysqli_fetch_array($cekid_keluar);

    $id_barang = $ambildata['id_barang'];
    $jumlahKeluar = $ambildata['jumlah'];

    $cekid_barang = mysqli_query($db, "select * from stock where id_barang='$id_barang'");
    $ambilStock = mysqli_fetch_array($cekid_barang);

    $stockSekar = $ambilStock['stock'];
    $tambahStock = $stockSekar + $jumlahKeluar;

    // Query Mengupdate stock barang setelah barang keluar di Cancel
    $updatestock = "UPDATE stock SET stock='$tambahStock' WHERE id_barang='$id_barang'";
    mysqli_query($db, $updatestock);


    // Query Menghapus data barang masuk
    $query = "DELETE FROM barangkeluar WHERE id_keluar = $id_keluar";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
