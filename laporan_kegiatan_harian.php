<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Session.php';
require __DIR__ . '/Config/Form.php';
require __DIR__ . '/Middleware/hasAuthAdmin.php';

use Model\TemaLaporan;
use Model\KegiatanLaporan;

$id = input_form($_GET['id']);
$surat_perintah_id = input_form($_GET['surat_perintah_id']);
$regu_id = input_form($_GET['regu_id']);

$model = new TemaLaporan();
$item = $model->find($id);

if ($item === null) {
    $_SESSION['type'] = 'danger';
    $_SESSION['message'] = 'Data Tidak Ditemukan';

    header('Location: laporan_harian.php?id=' . $surat_perintah_id . '&regu_id=' . $regu_id);
    die();
}

$modelKegiatanLaporan = new KegiatanLaporan();
$kegiatanLaporanItems = $modelKegiatanLaporan->indexByTemaLaporan($item['id']);


ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Top Navigation &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body class="layout-3">

    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="#" class="navbar-brand sidebar-gone-hide">Stisla</a>
                <div class="navbar-nav">
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                </div>
                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                </div>
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <?php require 'sidebar.php' ?>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Kegiatan</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="#">Kegiatan</a></div>
                        </div>
                    </div>
                    <div class="section-body">
                        <?php require_once __DIR__ . '/components/flash.php' ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Nama Kegiatan</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="<?php echo $item['nama'] ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" value="<?php echo $item['tanggal'] ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Kegiatan</h3>
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">Tambah Kegiatan</button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Person</th>
                                            <th>Sasaran</th>
                                            <th>Hasil Kegiatan</th>
                                            <th>Dokumentasi</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($kegiatanLaporanItems as $index => $kegiatanLaporanItem) { ?>
                                            <tr>
                                                <td><?php echo $index + 1 ?></td>
                                                <td><?php echo $kegiatanLaporanItem['nama'] ?></td>
                                                <td><?php echo $kegiatanLaporanItem['person'] ?></td>
                                                <td><?php echo $kegiatanLaporanItem['sasaran'] ?></td>
                                                <td><?php echo $kegiatanLaporanItem['hasil_kegiatan'] ?></td>
                                                <td>
                                                    <div class="kegiatan-harian-image">
                                                        <img src="files/<?php echo $kegiatanLaporanItem['dokumentasi'] ?>" alt="">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-<?php echo $index ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a href="hapus_kegiatan_harian_proses.php?id=<?php echo $kegiatanLaporanItem['id'] ?>" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </section>

                <?php foreach ($kegiatanLaporanItems as $index => $kegiatanLaporanItem) { ?> 
                    <!-- Modal -->
                    <div class="modal fade" id="modal-edit-<?php echo $index ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="edit_kegiatan_harian_proses.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $kegiatanLaporanItem['id'] ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kegiatan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" value="<?php echo $kegiatanLaporanItem['nama'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Person</label>
                                            <input type="text" class="form-control" name="person" value="<?php echo $kegiatanLaporanItem['person'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Sasaran</label>
                                            <input type="text" class="form-control" name="sasaran" value="<?php echo $kegiatanLaporanItem['sasaran'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Hasil Kegiatan</label>
                                            <input type="text" class="form-control" name="hasil_kegiatan" value="<?php echo $kegiatanLaporanItem['hasil_kegiatan'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Dokumentasi</label>
                                            <input type="file" class="form-control" name="dokumentasi">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                 <!-- Modal -->
                 <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="tambah_kegiatan_harian_proses.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Kegiatan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Person</label>
                                        <input type="text" class="form-control" name="person" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sasaran</label>
                                        <input type="text" class="form-control" name="sasaran" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Hasil Kegiatan</label>
                                        <input type="text" class="form-control" name="hasil_kegiatan" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Dokumentasi</label>
                                        <input type="file" class="form-control" name="dokumentasi" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
                </div>
                <div class="footer-right">
                2.3.0
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="assets/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>


<?php

$view = ob_get_clean();

reset_session_flash();

echo $view;

?>