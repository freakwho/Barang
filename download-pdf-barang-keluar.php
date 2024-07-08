<?php

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_barang = select("SELECT * FROM barangkeluar");

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
            <th>ID Keluar</th>
            <th>ID Barang</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Jumlah</th>
            <th>Status</th>  
        </tr>';

$no = 1;
foreach ($data_barang as $barangKeluar) {
    $content .= '             
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $barangKeluar['id_keluar'] . '</td>
            <td>' . $barangKeluar['id_barang'] . '</td>
            <td>' . $barangKeluar['nama_barang'] . '</td>
            <td>' . $barangKeluar['tanggal'] . '</td>
            <td>' . $barangKeluar['penerima'] . '</td>
            <td>' . $barangKeluar['jumlah'] . '</td>
            <td>' . $barangKeluar['status'] . '</td>
        </tr>    
    ';
}

$content .= '
    </table>
</page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
ob_start();
$html2pdf->output('Laporan Barang Keluar.pdf');
