<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Form.php';

use Model\SuratPerintah;
use Model\DataLaporan;
use Helpers\TanggalIndo;
use Model\ReguAnggota;

$model = new SuratPerintah();

$id = input_form($_GET['id'] ?? null);
$regu_id = input_form($_GET['regu_id'] ?? null);
$item = $model->find($id);

if ($item === null) {
    echo 'Data Tidak Ditemukan';
    die();
}

$modelDataLaporan = new DataLaporan();
$dataLaporanDasarItems = $modelDataLaporan->indexByLaporan($item['id'], 'surat_perintah', 'dasar');
$dataLaporanUntukItems = $modelDataLaporan->indexByLaporan($item['id'], 'surat_perintah', 'untuk');

$modelReguAnggota = new ReguAnggota();
$reguAnggotaItems = $modelReguAnggota->indexByReguId($item['regu_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        @media print and (width: 11cm) and (height: 22cm) {
            @page {
                margin: :0.5cm;
            }
        }
        @page {
            size: A4 potrait;
            margin: 5%;
        }
        
        .header {
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .header-image {
            margin: auto;
            width: 70px;
            height: 70px;
        }
        .header-image img {
            width: inherit;
            height: inherit;
        }
        .header-title {
            font-weight: 700;
        }
        .header-subtitle {
            font-weight: 700;
        }

        .table-border-all,
        .table-border-all th,
        .table-border-all td {
            border: 1px solid #212529;
        }

        .kegiatan-tanggal {
            font-weight: 700;
        }

        .kegiatan-gambar {
            width: 245px;
            height: 135px;
        }
        .kegiatan-gambar img {
            width: inherit;
            height: inherit;
        }

        body {
            font-size: 11pt;
        }

        .kop-box {
            width: 300px;
        }

        .tanda-tangan-box {
            width: 350px;
        }

        .tanda-tangan-space {
            height: 50px;
        }

        table.no-border td,
        table.no-border th {
            border-bottom-width: 0;
        }

        .dasar-kegiatan,
        .untuk-kegiatan {
            padding-left: 1rem;
        }

        .untuk-kegiatan li {
            margin-bottom: .5em;
        }

        .table-petugas,
        .table-tanda-tangan {
            margin: 0;
        }
        .table-petugas >:not(caption)>*>*,
        .table-tanda-tangan >:not(caption)>*>*{
            padding: 0;
        }

        .diperintahkan {
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="kop">
            <div class="kop-box text-center">
                <div>KEPOLISIAN DAERAH KALIMANTAN TIMUR</div>
                <div>RESOR KOTA SAMARINDA</div>
                <div>
                    <span class="border-bottom border-2 border-dark">SEKTOR KAWASAN PELABUHAN SAMARINDA</span>
                </div>
            </div>
        </div>
        <div class="header text-center">
            <div class="header-image">
                <img src="assets/img/logo.png" alt="">
            </div>
            <div class="header-title">
                <span class="border-bottom border-2 border-dark">
                    SURAT PERINTAH TUGAS PATROLI
                </span>
            </div>
            <div class="header-subtitle">
                Nomor: <?php echo $item['nomor'] ?>
            </div>
        </div>
        <div class="kegiatan">
            <table class="table no-border">
                <tr>
                    <td>Pertimbangan</td>
                    <td width="1%">:</td>
                    <td width="74%"><?php echo $item['pertimbangan'] ?></td>
                </tr>
                <tr>
                    <td>Dasar</td>
                    <td>:</td>
                    <td>
                        <ol type="1" class="dasar-kegiatan">
                            <?php foreach ($dataLaporanDasarItems as $dataLaporanDasarItem) { ?> 
                                <li><?php echo $dataLaporanDasarItem['isi'] ?></li>
                            <?php } ?>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="text-center diperintahkan">DIPERINTAHKAN</div>
                    </td>
                </tr>
                <tr>
                    <td>Kepada</td>
                    <td>:</td>
                    <td>
                        <table class="table table-petugas">
                            <tbody>
                                <?php foreach ($reguAnggotaItems as $index => $reguAnggotaItem) { ?>
                                    <tr>
                                        <td><?php echo $index + 1 ?>.</td>
                                        <td><?php echo $reguAnggotaItem['pangkat'] ?> <?php echo $reguAnggotaItem['nama'] ?></td>
                                        <td>NRP. <?php echo $reguAnggotaItem['kode'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Untuk</td>
                    <td>:</td>
                    <td class="text">
                        <ol type="1" class="untuk-kegiatan">
                            <?php foreach ($dataLaporanUntukItems as $dataLaporanUntukItem) { ?> 
                                <li><?php echo $dataLaporanUntukItem['isi'] ?></li>
                            <?php } ?>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <table class="table no-border">
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody class="border-0">
                <tr>
                    <td class="border-0">
                        <div class="tanda-tangan d-flex justify-content-end">
                            <div class="tanda-tangan-box">
                                <table class="table table-tanda-tangan">
                                    <tr>
                                        <td width="30%">Dikeluarkan di</td>
                                        <td width="4%">:</td>
                                        <td>Samarinda</td>
                                    </tr>
                                    <tr>
                                        <td>Pada tanggal</td>
                                        <td>:</td>
                                        <td><?php echo TanggalIndo::formatIndo($item['tanggal']) ?></td>
                                    </tr>
                                </table>
                                <div class="border-bottom border-2 border-dark"></div>
                                <div class="text-center">
                                    <div>An. KAPOLSEK KAWASAN PELABUHAN SAMARINDA</div>
                                    <div>KANIT SABHARA</div>
                                    <div class="tanda-tangan-space"></div>
                                    <div>
                                        <span class="border-bottom border-1 border-dark">DANOVAN, SH</span>
                                    </div>
                                    <div>IPTU NRP. 69050051</div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>