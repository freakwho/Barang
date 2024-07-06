<?php

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_barang = select("SELECT * FROM stock");

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
            <th>ID Barang</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Barcode</th>
            <th>Foto</th>    
        </tr>';

$no = 1;
foreach ($data_barang as $barang) {
    $content .= '             
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $barang['id_barang'] . '</td>
            <td>' . $barang['nama'] . '</td>
            <td>' . $barang['deskripsi'] . '</td>
            <td>' . $barang['harga'] . '</td>
            <td>' . $barang['stock'] . '</td>
            <td><img src="assets/other-img/tesbarcode.jpg" class="gambar"><br />' . $barang['barcode'] . '</td>
            <td><img src="assets/img/' . $barang['foto'] . '" class="gambar"></td>
        </tr>    
    ';
}

$content .= '
    </table>
</page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
ob_start();
$html2pdf->output('Laporan Barang.pdf');
