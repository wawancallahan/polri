<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\User;
use Model\Anggota;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = input_form($_POST['username'] ?? null);
    $password = input_form($_POST['password'] ?? null);
    $captcha = input_form($_POST['captcha'] ?? null);

    echo var_dump($captcha, $_SESSION['captcha']);
    die();

    if ($captcha !== $_SESSION['captcha']) {
        $_SESSION['type'] = 'danger';
        $_SESSION['message'] = 'Captcha Tidak Sesuai';
        header('location: index.php');
        die();
    }

    $userModel = new User($pdo);
    $item = $userModel->find($username, $password);

    if ($item !== null) {

        $anggotaModel = new Anggota();
        $anggota = $anggotaModel->findByUserId($item['id']);

        $_SESSION['is_login'] = 1;
        $_SESSION['anggota_id'] = $anggota['id'];
        $_SESSION['user_id'] = $item['id'];
        $_SESSION['nama'] = $item['nama'];
        $_SESSION['role'] = $item['role'];
        header('location: dashboard.php');
    } else {
        $_SESSION['type'] = 'danger';
        $_SESSION['message'] = 'Data Tidak Ditemukan';
        header('location: index.php');
    }

    die();
}

$_SESSION['type'] = 'danger';
$_SESSION['message'] = 'Terjadi Kesalahan Proses Data';

header('location: index.php');
die();