<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\LaporanHarianHasil;

$id = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = input_form($_POST['id'] ?? null);
    $key = input_form($_POST['key'] ?? null);
    $isi = input_form($_POST['isi'] ?? null);

    $model = new LaporanHarianHasil();
    $item = $model->patch([
        $key => $isi,
    ], $id);

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Diedit';

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
            break;
        case 'fail':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Diedit';
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