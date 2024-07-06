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
$activeWorksheet->setCellValue('B2', 'ID Barang');
$activeWorksheet->setCellValue('C2', 'Nama');
$activeWorksheet->setCellValue('D2', 'Deskripsi');
$activeWorksheet->setCellValue('E2', 'Harga');
$activeWorksheet->setCellValue('F2', 'Stock');
$activeWorksheet->setCellValue('G2', 'Kode Barcode');
$activeWorksheet->setCellValue('H2', 'Foto');

$data_mahasiswa = select("SELECT * FROM stock");

$no = 1;
$start = 3;

foreach ($data_mahasiswa as $mahasiswa) {
    $activeWorksheet->setCellValue('A' . $start, $no++)->getColumnDimension('A')->setAutoSize(true);
    $activeWorksheet->setCellValue('B' . $start, $mahasiswa['id_barang'])->getColumnDimension('B')->setAutoSize(true);
    $activeWorksheet->setCellValue('C' . $start, $mahasiswa['nama'])->getColumnDimension('C')->setAutoSize(true);
    $activeWorksheet->setCellValue('D' . $start, $mahasiswa['deskripsi'])->getColumnDimension('D')->setAutoSize(true);
    $activeWorksheet->setCellValue('E' . $start, $mahasiswa['harga'])->getColumnDimension('E')->setAutoSize(true);
    $activeWorksheet->setCellValue('F' . $start, $mahasiswa['stock'])->getColumnDimension('F')->setAutoSize(true);
    $activeWorksheet->setCellValue('G' . $start, $mahasiswa['barcode'])->getColumnDimension('F')->setAutoSize(true);
    $activeWorksheet->setCellValue('H' . $start, 'http://localhost/Barang/assets/img/' . $mahasiswa['foto'])->getColumnDimension('G')->setAutoSize(true);

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
$writer->save('Laporan Data Barang.xlsx');

// Meregenerate di Browser untuk melakukan ReDirect Donwload file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header('Content-Disposition: attachment;filename="Laporan Data Barang.xlsx"');
readfile('Laporan Data Barang.xlsx');

unlink('Laporan Data Barang.xlsx');
// Unlink berfungsi mengeluarkan tempat penyimpanan download dari default nya 

exit;
