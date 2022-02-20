<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';
// require __DIR__ . '/middleware/hasAuth.php';

use Model\SuratPerintah;
use Model\TemaLaporan;
use Model\KegiatanLaporan;
use Model\Regu;
use Helpers\TanggalIndo;

$id = input_form($_GET['id']);

$model = new SuratPerintah();
$item = $model->find($id);

if ($item === null) {
    echo 'Data Tidak Ditemukan';
    die();
}

$modelRegu = new Regu();
$reguItem = $modelRegu->find($item['regu_id']);

$data = [];

$modelTemaLaporanKegiatan = new TemaLaporan();
$temaLaporanKegiatanItems = $modelTemaLaporanKegiatan->indexBySuratPerintah($item['id']);

$modelKegiatanLaporan = new KegiatanLaporan();

foreach ($temaLaporanKegiatanItems as $temaLaporanKegiatanItem) {
    $kegiatanLaporanItems = $modelKegiatanLaporan->indexByTemaLaporan($temaLaporanKegiatanItem['id']);

    $data[] = [
        'tema_laporan' => $temaLaporanKegiatanItem,
        'kegiatan_laporan' => $kegiatanLaporanItems
    ];
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
            size: A4 landscape;
            margin: 5%;
        }
        
        .header {
            margin-top: 1em;
            margin-bottom: 1em;
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
        
        .kop {
            font-size: 11pt;
        }

        .header {
            font-size: 14pt;
        }

        body {
            font-size: 12pt;
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
            <div class="header-title">LAPORAN HARIAN POLSEK KP SAMARINDA</div>
            <div class="header-subtitle">
                <span class="border-bottom border-2 border-dark">    
                    <?php echo $reguItem['nama'] ?>
                </span>
            </div>
        </div>
        <div class="kegiatan">
            <?php
                foreach ($data as $index => $item) {
            ?>
                <span class="kegiatan-nomor">
                    <?php echo $index + 1 ?>.
                </span>
                <span class="kegiatan-judul">
                    <?php echo $item['tema_laporan']['nama'] ?>
                </span>
                ( <span class="kegiatan-tanggal">Hari <?php echo TanggalIndo::hariIndo($item['tema_laporan']['tanggal']) ?> <?php echo TanggalIndo::formatIndo($item['tema_laporan']['tanggal']) ?></span> )

                <table class="table table-border-all mt-2">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KEGIATAN</th>
                            <th>PERSON</th>
                            <th>SASARAN</th>
                            <th>HASIL KEGIATAN</th>
                            <th>DOKUMENTASi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($item['kegiatan_laporan'] as $indexHarian => $kegiatanHarianItem) { 
                        ?>
                            <tr>
                                <td><?php echo $indexHarian + 1 ?></td>
                                <td><?php echo $kegiatanHarianItem['nama'] ?></td>
                                <td><?php echo $kegiatanHarianItem['person'] ?></td>
                                <td><?php echo $kegiatanHarianItem['sasaran'] ?></td>
                                <td><?php echo $kegiatanHarianItem['hasil_kegiatan'] ?></td>
                                <td>
                                    <div class="kegiatan-gambar">
                                        <img src="files/<?php echo $kegiatanHarianItem['dokumentasi'] ?>" alt="">
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            <?php 
                }
            ?>
        </div>
        <table class="table">
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
                                <div>Samarinda, 28 Januari 2022</div>
                                <div>An. KAPOLSEK KAWASAN PELABUHAN SAMARINDA</div>
                                <div>KANIT SABHARA</div>
                                <div class="tanda-tangan-space"></div>
                                <div>
                                    <span class="border-bottom border-1 border-dark">DANOVAN, SH</span>
                                </div>
                                <div>IPTU NRP. 69050051</div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>