<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\ReguAnggota;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regu_id = input_form($_POST['regu_id'] ?? null);
    $anggota_id = input_form($_POST['anggota_id'] ?? null);
    $type = input_form($_POST['type'] ?? null);

    $model = new ReguAnggota();

    $tambah_regu_anggota = true;

    if ($type == 1) {
        $countKetua = $model->findCountKetua($regu_id);

        if ($countKetua === null || $countKetua === 1) {
            $item = 'fail_ketua';
            $tambah_regu_anggota = false;
        }
    }

    if ($tambah_regu_anggota) {
        $item = $model->create([
            'regu_id' => $regu_id,
            'anggota_id' => $anggota_id,
            'type' => $type
        ]);
    }

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Ditambah';

            header('location: regu_anggota.php?id=' . $regu_id);
            die();
            break;
        case 'fail':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Ditambah';
            break;
        case 'fail_ketua':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Anggota Tipe Ketua Hanya Boleh 1 Saja';
            break;
        case 'validation':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Semua bidang isian wajib diisi';
            break;
    }

    header('location: regu_anggota.php?id=' . $regu_id);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: regu.php');
die();