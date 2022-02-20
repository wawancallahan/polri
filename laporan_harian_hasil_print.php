<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Form.php';

use Model\LaporanHarianHasil;
use Model\SuratPerintah;
use Model\DataLaporan;
use Helpers\TanggalIndo;
use Model\ReguAnggota;
use Model\Anggota;

$model = new LaporanHarianHasil();

$id = input_form($_GET['id'] ?? null);
$item = $model->find($id);

if ($item === null) {
    echo 'Data Tidak Ditemukan';
    die();
}

$modelSuratPerintah = new SuratPerintah();
$suratPerintah = $modelSuratPerintah->find($item['surat_perintah_id']);

$modelDataLaporan = new DataLaporan();
$dataLaporanDasarItems = $modelDataLaporan->indexByLaporan($item['id'], 'laporan_harian_hasil', 'dasar');

$modelReguAnggota = new ReguAnggota();
$reguAnggotaItems = $modelReguAnggota->indexByReguId($suratPerintah['regu_id']);

$reguAnggotaKetua = $modelReguAnggota->findKetuaByReguId($suratPerintah['regu_id']);

$anggota = null;

$modelAnggota = new Anggota();
if ($reguAnggotaKetua !== null) {
    $anggota = $modelAnggota->find($reguAnggotaKetua['anggota_id']);
}

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
            width: 400px;
        }

        .tanda-tangan-space {
            height: 50px;
        }

        table.no-border td,
        table.no-border th {
            border-bottom-width: 0;
        }

        .dasar-kegiatan {
            padding-left: 1rem;
        }

        .table-petugas {
            margin: 0;
        }
        .table-petugas >:not(caption)>*>* {
            padding: 0;
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
                LAPORAN HARIAN HASIL PELAKSANAAN PATROLI
            </div>
            <div class="header-subtitle">
                <span class="border-bottom border-2 border-dark">
                    POLSEK KAWASAN PELABUHAN SAMARINDA 
                </span>
            </div>
        </div>
        <div class="kegiatan">
            <table class="table no-border">
                <tr>
                    <td>Dasar</td>
                    <td width="1%">:</td>
                    <td width="74%">
                        <ol type="1" class="dasar-kegiatan">
                            <?php foreach ($dataLaporanDasarItems as $dataLaporanDasarItem) { ?> 
                                <li><?php echo $dataLaporanDasarItem['isi'] ?></li>
                            <?php } ?>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td>Petugas Patroli</td>
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
                    <td>Waktu Patroli</td>
                    <td>:</td>
                    <td>
                        <?php echo $item['waktu'] ?> 
                    </td>
                </tr>
                <tr>
                    <td>Rute Sasaran Patroli</td>
                    <td>:</td>
                    <td>
                        <?php echo $item['rute'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Kendaraan NoPol</td>
                    <td>:</td>
                    <td>
                        <?php echo $item['kendaraan'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Hal yang ditemukan</td>
                    <td>:</td>
                    <td><?php echo $item['ditemukan'] ?></td>
                </tr>
                <tr>
                    <td>Tindakan yg diambil</td>
                    <td>:</td>
                    <td><?php echo $item['tindakan'] ?></td>
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
                            <div class="tanda-tangan-box text-center">
                                <div>Samarinda, <?php echo TanggalIndo::formatIndo($suratPerintah['tanggal']) ?></div>
                                <div>PETUGAS PATROLI</div>
                                <div class="tanda-tangan-space"></div>
                                <div>
                                    <span class="border-bottom border-1 border-dark"><?php echo $anggota['nama'] ?? '-' ?></span>
                                </div>
                                <div><?php echo $anggota['pangkat'] ?? '-' ?> NRP. <?php echo $anggota['kode'] ?? '-' ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>