<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\Anggota;
use Model\User;
use Model\ReguAnggota;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = input_form($_GET['id'] ?? null);

    $model = new Anggota();
    $data = $model->findByUserId($id);

    $reguAnggotaModel = new ReguAnggota();
    $reguAnggotaModel->deleteByAnggotaId($data['id']);

    $item = $model->delete($data['id']);

    $userModel = new User();
    $userModel->delete($data['user_id']);

    switch ($item) {
        case true:
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Dihapus';

            header('location: anggota.php');
            die();
            break;
        case false:
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Dihapus';
            break;
    }

    header('location: anggota.php');
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: anggota.php');
die();