<?php

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

$data_barang = select("SELECT * FROM barangcancel");

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
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Pengirim</th>
            <th>Jumlah</th>
            <th>Status</th>  
        </tr>';

$no = 1;
foreach ($data_barang as $barangCancel) {
    $content .= '             
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $barangCancel['id_barang'] . '</td>
            <td>' . $barangCancel['nama_barang'] . '</td>
            <td>' . $barangCancel['tanggal'] . '</td>
            <td>' . $barangCancel['penerima'] . '</td>
            <td>' . $barangCancel['pengirim'] . '</td>
            <td>' . $barangCancel['jumlah'] . '</td>
            <td>' . $barangCancel['status'] . '</td>
        </tr>    
    ';
}

$content .= '
    </table>
</page>';

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
ob_start();
$html2pdf->output('Cancel Report.pdf');
