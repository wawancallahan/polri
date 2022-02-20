<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\KegiatanLaporan;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = input_form($_GET['id'] ?? null);

    $model = new KegiatanLaporan();
    $data = $model->find($id);

    // directory in which the uploaded file will be moved
    $uploadFileDir = './files/';

    if (!is_dir($uploadFileDir)) {
        # jika tidak maka folder harus dibuat terlebih dahulu
        mkdir($uploadFileDir, 0777, $rekursif = true);
    }
    
    $dest_path = $uploadFileDir . $data['dokumentasi'];

    $deleteFile = unlink($dest_path);

    $item = $model->delete($id);

    switch ($item) {
        case true:
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Dihapus';

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
            break;
        case false:
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Dihapus';
            break;
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('Location: ' . $_SERVER['HTTP_REFERER']);
die();