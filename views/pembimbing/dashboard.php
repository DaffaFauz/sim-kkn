<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
checkLogin();
checkRole(['Pembimbing']);
$pageTitle = 'Dashboard Pembimbing';

// Query Untuk Mendapatkan Data Mahasiswa sesuai dengan Kelompok yang dibimbing
$stmt = $pdo->prepare("SELECT * FROM mahasiswa INNER JOIN anggota_kelompok ON mahasiswa.id_mahasiswa = anggota_kelompok.id_mahasiswa INNER JOIN kelompok ON anggota_kelompok.id_kelompok = kelompok.id_kelompok INNER JOIN dosen ON dosen.id_kelompok = kelompok.id_kelompok INNER JOIN user ON dosen.id_user = user.id_user INNER JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi INNER JOIN fakultas ON mahasiswa.id_fakultas = fakultas.id_fakultas WHERE user.id_user = ? AND dosen.id_kelompok = kelompok.id_kelompok");
$stmt->execute([$_SESSION['id_user']]);
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mendapatkan laporan kegiatan harian dari kelompok yang dibimbing
$q = $pdo->prepare("SELECT * FROM laporan_harian INNER JOIN kelompok ON laporan_harian.id_kelompok = kelompok.id_kelompok INNER JOIN dosen ON dosen.id_kelompok = kelompok.id_kelompok INNER JOIN user ON dosen.id_user = user.id_user WHERE user.id_user = ? AND dosen.id_kelompok = kelompok.id_kelompok");
$q->execute([$_SESSION['id_user']]);
$laporan = $q->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
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
    <!-- Tabel laporan kegiatan harian -->
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Kegiatan Harian</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($laporan){
                             $no = 1;
                            foreach($laporan as $laporan): ?>
                            <tr>
                                <td><?= htmlspecialchars($no++)?></td>
                                <td><?= htmlspecialchars(date('d-M-Y', strtotime($laporan['tanggal'])))?></td>
                                <td><?= htmlspecialchars($laporan['judul_laporan'])?></td>
                                <td><button type="button" class="btn btn-primary" data-modal="modal" data-target="#modal"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                            </tr>
                            <?php endforeach;} else{?>
                             <td colspan="6" class="text-center">Belum ada laporan kegiatan harian yang tersedia.</td>
                             <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '../layout/footer.php'; ?>