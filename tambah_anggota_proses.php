<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\Anggota;
use Model\User;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = input_form($_POST['nama'] ?? null);
    $pangkat = input_form($_POST['pangkat'] ?? null);
    $nrp = input_form($_POST['nrp'] ?? null);
    $username = input_form($_POST['username'] ?? null);
    $password = input_form($_POST['password'] ?? null);

    $userModel = new User();

    $countUsername = $userModel->findCountUsername($username);

    if ($countUsername !== null && $countUsername === 0) {
        $userId = $userModel->create([
            'nama' => $nama,
            'username' => $username,
            'password' => md5($password),
            'role' => 'ANGGOTA'
        ]);
    
        $model = new Anggota();
        $item = $model->create([
            'nama' => $nama,
            'pangkat' => $pangkat,
            'kode' => $nrp,
            'user_id' => $userId
        ]);
    } else {
        $item = 'fail_username';
    }

    switch ($item) {
        case 'success':
            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Data Berhasil Ditambah';

            header('location: anggota.php');
            die();
            break;
        case 'fail':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Data Gagal Ditambah';
            break;
        case 'fail_username':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Username telah ada sebelumnya';
            break;
        case 'validation':
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Semua bidang isian wajib diisi';
            break;
    }

    header('location: tambah_anggota.php');
    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: tambah_anggota.php');
die();