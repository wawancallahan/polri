<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\SuratPerintah;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regu_id = input_form($_POST['regu_id'] ?? null);
    $nomor = input_form($_POST['nomor'] ?? null);
    $tanggal = input_form($_POST['tanggal'] ?? null);
    $dikeluarkan_di = 'Samarinda';

    $model = new SuratPerintah();
    $item = $model->create([
        'regu_id' => $regu_id,
        'nomor' => $nomor,
        'tanggal' => $tanggal,
        'dikeluarkan_di' => $dikeluarkan_di
    ]);

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Ditambah';

            header('location: regu_perintah.php?id=' . $regu_id);
            die();
            break;
        case 'fail':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Ditambah';
            break;
        case 'validation':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Semua bidang isian wajib diisi';
            break;
    }

    header('location: regu_perintah.php?id=' . $regu_id);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: regu.php');
die();