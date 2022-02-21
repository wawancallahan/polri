<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\SuratPerintah;
use Model\DataLaporan;
use Model\LaporanHarianHasil;
use Model\TemaLaporan;
use Model\KegiatanLaporan;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = input_form($_GET['id'] ?? null);
    $regu_id = input_form($_GET['regu_id'] ?? null);

    $model = new SuratPerintah();
    $data = $model->find($id);

    $laporanHarianHasilModel = new LaporanHarianHasil();
    $laporanHarianHasilItem = $laporanHarianHasilModel->findBySuratPerintah($data['id']);

    $dataLaporanModel = new DataLaporan();
    $dataLaporanModel->deleteByLaporan($data['id'], 'surat_perintah', 'dasar');
    $dataLaporanModel->deleteByLaporan($data['id'], 'surat_perintah', 'untuk');
    $dataLaporanModel->deleteByLaporan($laporanHarianHasilItem['id'], 'laporan_harian_hasil', 'dasar');

    $temaLaporanModel = new TemaLaporan();
    $temaLaporanItems = $temaLaporanModel->indexBySuratPerintah($data['id']);

    $kegiatanLaporanModel = new KegiatanLaporan();

    // directory in which the uploaded file will be moved
    $uploadFileDir = './files/';

    if (!is_dir($uploadFileDir)) {
        # jika tidak maka folder harus dibuat terlebih dahulu
        mkdir($uploadFileDir, 0777, $rekursif = true);
    }

    foreach ($temaLaporanItems as $temaLaporanItem) {
        $kegiatanLaporanItems = $kegiatanLaporanModel->indexByTemaLaporan($temaLaporanItem['id']);

        foreach ($kegiatanLaporanItems as $kegiatanLaporanItem) {
            $dest_path = $uploadFileDir . $kegiatanLaporanItem['dokumentasi'];

            $deleteFile = unlink($dest_path);
        }

        $kegiatanLaporanModel->deleteByTemaLaporan($temaLaporanItem['id']);
    }
    
    $temaLaporanModel->deleteBySuratPerintahId($data['id']);
    $laporanHarianHasilModel->deleteBySuratPerintahId($data['id']);

    $item = $model->delete($id);

    switch ($item) {
        case true:
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Dihapus';

            header('location: regu_perintah.php?id=' . $regu_id);
            die();
            break;
        case false:
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Dihapus';
            break;
    }

    header('location: regu_perintah.php?id=' . $regu_id);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: regu.php');
die();