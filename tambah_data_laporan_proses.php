<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\DataLaporan;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = input_form($_POST['id'] ?? null);
    $regu_id = input_form($_POST['regu_id'] ?? null);
    $modelInput = input_form($_POST['model'] ?? null);
    $jenis = input_form($_POST['jenis'] ?? null);
    $isi = input_form($_POST['isi'] ?? null);

    $model = new DataLaporan();
    $item = $model->create([
        'id' => $id,
        'model' => $modelInput,
        'jenis' => $jenis,
        'isi' => $isi
    ]);

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Ditambah';

            header('Location: ' . $_SERVER['HTTP_REFERER']);
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

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('Location: ' . $_SERVER['HTTP_REFERER']);
die();