<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\SuratPerintah;

$id = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = input_form($_POST['id'] ?? null);
    $regu_id = input_form($_POST['regu_id'] ?? null);
    $nomor = input_form($_POST['nomor'] ?? null);
    $tanggal = input_form($_POST['tanggal'] ?? null);

    $model = new SuratPerintah();
    $item = $model->update([
        'nomor' => $nomor,
        'tanggal' => $tanggal
    ], $id);

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Diedit';

            header('location: regu_perintah.php?id=' . $regu_id);
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

    header('location: regu_perintah.php?id=' . $regu_id);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: regu.php');
die();