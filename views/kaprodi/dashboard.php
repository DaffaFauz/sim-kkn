<?php
require_once '..\..\auth\check_login.php';
require_once '../../includes/functions.php';
checkLogin();

require_once '../../config/db.php';
// $jml_mahasiswa = $pdo->query("SELECT COUNT(*) FROM mahasiswa")->fetchColumn();
//$jml_dosen = $pdo->query("SELECT COUNT(*) FROM dosen INNER JOIN user ON dosen.id_user = user.id_user WHERE user.role = 'Dosen Pembimbing'")->fetchColumn();
// $jml_kelompok = $pdo->query("SELECT COUNT(*) FROM kelompok")->fetchColumn();
//$jml_lokasi = $pdo->query("SELECT COUNT(*) FROM lokasi")->fetchColumn();
$pageTitle = 'Dashboard Admin'
?>

<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Jumlah Data Mahasiswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //htmlspecialchars($jml_mahasiswa) 
                                                                            ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Data Dosen Pembimbing -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Dosen Pembimbing
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //htmlspecialchars($jml_dosen)
                                                                            ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Data Kelompok -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jumlah Kelompok
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php //htmlspecialchars($jml_kelompok)
                                                                                            ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Data Lokasi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Lokasi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //htmlspecialchars($jml_lokasi)
                                                                            ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col mb-4">

        <!-- Page Heading Laporan Kegiatan Harian Kelompok -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Kegiatan Mahasiswa</h1>
        </div>
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Kegiatan</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kelompok</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>12-07-2024</td>
                            <td>Kelompok A</td>
                            <td>Survey Lokasi</td>
                            <td>Desa A</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>13-07-2024</td>
                            <td>Kelompok B</td>
                            <td>Pemetaan Wilayah</td>
                            <td>Desa B</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>14-07-2024</td>
                            <td>Kelompok C</td>
                            <td>Wawancara Masyarakat</td>
                            <td>Desa C</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- End of Content Column -->
</div>



<!-- Footer -->
<?php include '../layout/footer.php'; ?>