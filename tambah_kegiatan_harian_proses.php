<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';

use Model\KegiatanLaporan;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = input_form($_POST['id'] ?? null);
    $nama = input_form($_POST['nama'] ?? null);
    $person = input_form($_POST['person'] ?? null);
    $sasaran = input_form($_POST['sasaran'] ?? null);
    $hasil_kegiatan = input_form($_POST['hasil_kegiatan'] ?? null);

    $newFileName = null;

    if ($_FILES['dokumentasi']['size'] !== 0) {
        $fileTmpPath = $_FILES['dokumentasi']['tmp_name'];
        $fileName = $_FILES['dokumentasi']['name'];
        $fileSize = $_FILES['dokumentasi']['size'];
        $fileType = $_FILES['dokumentasi']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if ( ! in_array($fileExtension, $allowedfileExtensions)) {
            echo var_dump($fileExtension);
            die();

            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Ekstensi File Hanya Boleh .jpg, .jpeg, .gif, .png';
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    
        // directory in which the uploaded file will be moved
        $uploadFileDir = './files/';
    
        if (!is_dir($uploadFileDir)) {
            # jika tidak maka folder harus dibuat terlebih dahulu
            mkdir($uploadFileDir, 0777, $rekursif = true);
        }
    
        $dest_path = $uploadFileDir . $newFileName;
    
        if( ! move_uploaded_file($fileTmpPath, $dest_path)) {
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Gagal Upload File';
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }

    $model = new KegiatanLaporan();
    $item = $model->create([
        'tema_laporan_id' => $id,
        'nama' => $nama,
        'person' => $person,
        'sasaran' => $sasaran,
        'hasil_kegiatan' => $hasil_kegiatan,
        'dokumentasi' => $newFileName
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