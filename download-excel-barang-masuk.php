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

// // Membatasi Halaman sesuai user login
// if ($_SESSION['level'] != 1 and $_SESSION['level'] != 3) {
//     echo "<script>
//             alert('Perhatioan anda tidak punya hak akses');
//             document.location.href = 'index.php';
//           </script>";
//     exit;
// }

require 'config/app.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$activeWorksheet->setCellValue('A2', 'No.');
$activeWorksheet->setCellValue('B2', 'ID Masuk');
$activeWorksheet->setCellValue('C2', 'ID Barang');
$activeWorksheet->setCellValue('D2', 'Nama Barang');
$activeWorksheet->setCellValue('E2', 'Tanggal');
$activeWorksheet->setCellValue('F2', 'Pengirim');
$activeWorksheet->setCellValue('G2', 'Jumlah');
$activeWorksheet->setCellValue('H2', 'Status');

$data_barang = select("SELECT * FROM barangmasuk");

$no = 1;
$start = 3;

foreach ($data_barang as $barangMasuk) {
    $activeWorksheet->setCellValue('A' . $start, $no++)->getColumnDimension('A')->setAutoSize(true);
    $activeWorksheet->setCellValue('B' . $start, $barangMasuk['id_masuk'])->getColumnDimension('B')->setAutoSize(true);
    $activeWorksheet->setCellValue('C' . $start, $barangMasuk['id_barang'])->getColumnDimension('C')->setAutoSize(true);
    $activeWorksheet->setCellValue('D' . $start, $barangMasuk['nama_barang'])->getColumnDimension('D')->setAutoSize(true);
    $activeWorksheet->setCellValue('E' . $start, $barangMasuk['tanggal'])->getColumnDimension('E')->setAutoSize(true);
    $activeWorksheet->setCellValue('F' . $start, $barangMasuk['pengirim'])->getColumnDimension('F')->setAutoSize(true);
    $activeWorksheet->setCellValue('G' . $start, $barangMasuk['jumlah'])->getColumnDimension('G')->setAutoSize(true);
    $activeWorksheet->setCellValue('H' . $start, $barangMasuk['status'])->getColumnDimension('H')->setAutoSize(true);

    $start++;
}


$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$border = $start - 1;
$activeWorksheet->getStyle('A2:H' . $border)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Laporan Data Barang Masuk.xlsx');

// Meregenerate di Browser untuk melakukan ReDirect Donwload file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header('Content-Disposition: attachment;filename="Laporan Data Barang Masuk.xlsx"');
readfile('Laporan Data Barang Masuk.xlsx');

unlink('Laporan Data Barang Masuk.xlsx');
// Unlink berfungsi mengeluarkan tempat penyimpanan download dari default nya 

exit;
