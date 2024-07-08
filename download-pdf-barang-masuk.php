<?php

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_barang = select("SELECT * FROM barangmasuk");

$content .= '<style type="text/css">
    .gambar {
        width: 50px;
    }
</style>';

$content .= '
<page>
    <table border = "1" align = "center">
        <tr>
            <th>No</th>
            <th>ID Masuk</th>
            <th>ID Barang</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Pengirim</th>
            <th>Jumlah</th>
            <th>Status</th>  
        </tr>';

$no = 1;
foreach ($data_barang as $barangMasuk) {
    $content .= '             
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $barangMasuk['id_masuk'] . '</td>
            <td>' . $barangMasuk['id_barang'] . '</td>
            <td>' . $barangMasuk['nama_barang'] . '</td>
            <td>' . $barangMasuk['tanggal'] . '</td>
            <td>' . $barangMasuk['pengirim'] . '</td>
            <td>' . $barangMasuk['jumlah'] . '</td>
            <td>' . $barangMasuk['status'] . '</td>
        </tr>    
    ';
}

$content .= '
    </table>
</page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
ob_start();
$html2pdf->output('Laporan Barang Masuk.pdf');
