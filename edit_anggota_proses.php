<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\Anggota;
use Model\User;

$id = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = input_form($_POST['id'] ?? null);
    $nama = input_form($_POST['nama'] ?? null);
    $pangkat = input_form($_POST['pangkat'] ?? null);
    $nrp = input_form($_POST['nrp'] ?? null);
    $username = input_form($_POST['username'] ?? null);
    $password = input_form($_POST['password'] ?? null);

    $userModel = new User();

    $countUsername = $userModel->findCountUsername($username, $id);

    if ($countUsername !== null && $countUsername === 0) {
        $userModel->update([
            'nama' => $nama,
            'username' => $username,
            'password' => $password !== "" ? md5($password) : ""
        ], $id);
    
        $model = new Anggota();
        $item = $model->update([
            'nama' => $nama,
            'pangkat' => $pangkat,
            'kode' => $nrp
        ], $id);
    } else {
        $item = 'fail_username';
    }

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Diedit';

            header('location: anggota.php');
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

    header('location: edit_anggota.php?id=' . $id);
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: edit_anggota.php?id=' . $id);
die();