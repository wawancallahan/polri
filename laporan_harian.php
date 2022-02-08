<?php
    $judul = "SATGAS OPS KONTINJENSI  COVID – 19 AMAN NUSA- II 2020";

    $daftarKegiatan = [
        [
            'judul' => 'SATGAS PENCEGAHAN',
            'tanggal' => 'HARI JUMAT TANGGAL 28 JANUARI 2022',
            'kegiatan' => [
                [
                    'nama' => 'Melaksanakan PATROLI DAERAH RAWAN PENULARAN COVID 19 dan Melaksanakan himbauan Pencegahan Penyebaran Virus Corona',
                    'person' => '2 personil unit Sabhara polsek KP Smda',
                    'sasaran' => 'bpk Endra buruh Pelabuhan samarinda',
                    'hasil' => 'masyarakat agar pake masker dan mencuci tangan dengan sabun, jaga jarak dengan lawan bicara menghindari kumpulan org banyak yg tidak dikena',
                    'dokumentasi' => 'https://i.pinimg.com/564x/d3/2c/c7/d32cc7f40797ef35c526e9c840333ddc.jpg'
                ]
            ]
        ]
    ];
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
                    <?php echo $judul ?>
                </span>
            </div>
        </div>
        <div class="kegiatan">
            <?php
                foreach ($daftarKegiatan as $index => $kegiatanItem) {
            ?>
                <span class="kegiatan-nomor">
                    <?php echo $index + 1 ?>.
                </span>
                <span class="kegiatan-judul">
                    <?php echo $kegiatanItem['judul'] ?>
                </span>
                ( <span class="kegiatan-tanggal"><?php echo $kegiatanItem['tanggal'] ?></span> )

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
                            foreach ($kegiatanItem['kegiatan'] as $indexHarian => $kegiatanHarianItem) { 
                        ?>
                            <tr>
                                <td><?php echo $indexHarian + 1 ?></td>
                                <td><?php echo $kegiatanHarianItem['nama'] ?></td>
                                <td><?php echo $kegiatanHarianItem['person'] ?></td>
                                <td><?php echo $kegiatanHarianItem['sasaran'] ?></td>
                                <td><?php echo $kegiatanHarianItem['hasil'] ?></td>
                                <td>
                                    <div class="kegiatan-gambar">
                                        <img src="<?php echo $kegiatanHarianItem['dokumentasi'] ?>" alt="">
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