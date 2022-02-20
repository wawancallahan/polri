<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Form.php';
require __DIR__ . '/Config/Session.php';
// require __DIR__ . '/middleware/hasAuth.php';

use Model\Regu;
use Model\LaporanHarianHasil;
use Model\SuratPerintah;
use Model\DataLaporan;

$model = new LaporanHarianHasil();

$id = input_form($_GET['id'] ?? null);
$regu_id = input_form($_GET['regu_id'] ?? null);
$item = $model->findBySuratPerintah($id);

if ($item === null) {
    $_SESSION['type'] = 'danger';
    $_SESSION['message'] = 'Data Tidak Ditemukan';

    header('location: regu_perintah.php?id=' . $regu_id);
    die();
}

$modelSuratPerintah = new SuratPerintah();
$suratPerintah = $modelSuratPerintah->find($id);

$modelDataLaporan = new DataLaporan();
$dataLaporanDasarItems = $modelDataLaporan->indexByLaporan($item['id'], 'laporan_harian_hasil', 'dasar');

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
</head>

<body class="layout-3">

    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.html" class="navbar-brand sidebar-gone-hide">Stisla</a>
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
                        <h1>Surat Perintah Regu</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="#">Surat Perintah Regu</a></div>
                        </div>
                    </div>
                    <div class="section-body">

                        <?php require_once __DIR__ . '/components/flash.php' ?>

                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Surat Perintah Regu</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nomor</label>
                                    <input type="text" class="form-control" value="<?php echo $suratPerintah['nomor'] ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" value="<?php echo $suratPerintah['tanggal'] ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Harian Hasil</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Dasar</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah-dasar">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Isi</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dataLaporanDasarItems as $index => $dataLaporanDasarItem) { ?>
                                                <tr>
                                                    <td><?php echo $index + 1 ?></td>
                                                    <td><?php echo $dataLaporanDasarItem['isi'] ?></td>
                                                    <td>
                                                        <a href="hapus_data_laporan_proses.php?id=<?php echo $dataLaporanDasarItem['id'] ?>" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Waktu Patroli</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-waktu">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                               
                               <div class="form-group">
                                   <textarea id="" rows="5" class="form-control" disabled><?php echo $item['waktu'] ?></textarea>
                               </div>

                               <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Rute Sasaran Patroli</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-rute">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                               
                               <div class="form-group">
                                   <textarea id="" rows="5" class="form-control" disabled><?php echo $item['rute'] ?></textarea>
                               </div>

                               <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Kendaraan NoPol</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-kendaraan">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                               
                               <div class="form-group">
                                   <textarea id="" rows="5" class="form-control" disabled><?php echo $item['kendaraan'] ?></textarea>
                               </div>

                               <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Hal yang ditemukan</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ditemukan">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                               
                               <div class="form-group">
                                   <textarea id="" rows="5" class="form-control" disabled><?php echo $item['ditemukan'] ?></textarea>
                               </div>

                               <div class="row mb-1">
                                    <div class="col-6">
                                        <label for="">Tindakan yang diambil</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-tindakan">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                </div>
                               
                               <div class="form-group">
                                   <textarea id="" rows="5" class="form-control" disabled><?php echo $item['tindakan'] ?></textarea>
                               </div>

                               <div class="form-group">
                                   <a href="laporan_harian_hasil_print.php?id=<?php echo $item['id'] ?>" target="_blank" class="btn btn-info btn-block">
                                       <i class="fa fa-print"></i> Print Laporan Hasil Harian
                                   </a>
                               </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </section>

                <!-- Modal -->
                <div class="modal fade" id="modal-waktu" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="update_laporan_harian_hasil.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="key" value="waktu">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Waktu Patroli</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Waktu Patroli</label>
                                        <textarea id="" rows="5" class="form-control" name="isi" required><?php echo $item['waktu'] ?></textarea>
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

                <!-- Modal -->
                <div class="modal fade" id="modal-rute" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="update_laporan_harian_hasil.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="key" value="rute">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Rute Sasaran Patroli</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Rute Sasaran Patroli</label>
                                        <textarea id="" rows="5" class="form-control" name="isi" required><?php echo $item['rute'] ?></textarea>
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

                <!-- Modal -->
                <div class="modal fade" id="modal-kendaraan" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="update_laporan_harian_hasil.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="key" value="kendaraan">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kendaraan NoPol</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Kendaraan NoPol</label>
                                        <textarea id="" rows="5" class="form-control" name="isi" required><?php echo $item['kendaraan'] ?></textarea>
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

                <!-- Modal -->
                <div class="modal fade" id="modal-ditemukan" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="update_laporan_harian_hasil.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="key" value="ditemukan">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Hal yang ditemukan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Hal yang ditemukan</label>
                                        <textarea id="" rows="5" class="form-control" name="isi" required><?php echo $item['ditemukan'] ?></textarea>
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

                <!-- Modal -->
                <div class="modal fade" id="modal-tindakan" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="update_laporan_harian_hasil.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="key" value="tindakan">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Tindakan yang diambil</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Tindakan yang diambil</label>
                                        <textarea id="" rows="5" class="form-control" name="isi" required><?php echo $item['tindakan'] ?></textarea>
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

                 <!-- Modal -->
                 <div class="modal fade" id="modal-tambah-dasar" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="tambah_data_laporan_proses.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
                                <input type="hidden" name="regu_id" value="<?php echo $regu_id ?>">
                                <input type="hidden" name="jenis" value="dasar">
                                <input type="hidden" name="model" value="laporan_harian_hasil">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Poin Dasar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Isi</label>
                                        <input type="text" class="form-control" name="isi" required>
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