<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Mahasiswa']);
$pageTitle = 'Dashboard Mahasiswa';

// Status mahasiswa
$stmt = $pdo->prepare("SELECT mahasiswa.status, user.id_user FROM mahasiswa INNER JOIN user ON mahasiswa.id_user = user.id_user WHERE user.id_user = ?");
$stmt->execute([$_SESSION['id_user']]);
$mahasiswa = $stmt->fetch();

if($mahasiswa['status'] === 'Ditolak'){
    $verif_text_class = 'text-danger';
    $verif_icon = 'fa fa-times text-danger';
    $verif_label = 'Ditolak';
}elseif($mahasiswa['status'] === 'Pending' || $mahasiswa['status'] === 'Diverifikasi Kaprodi'){
    $verif_text_class = 'text-warning';
    $verif_icon = 'fa fa-hourglass-half text-warning';
    $verif_label = 'Pending';
}elseif($mahasiswa['status'] === 'Diverifikasi'){
    $verif_text_class = 'text-success';
    $verif_icon = 'fa fa-check text-success';
    $verif_label = 'Terverifikasi';
}

// Query untuk mendapatkan laporan kegiatan harian dari kelompoknya
$q = $pdo->prepare("SELECT * FROM laporan_harian INNER JOIN kelompok ON laporan_harian.id_kelompok = kelompok.id_kelompok INNER JOIN anggota_kelompok ON anggota_kelompok.id_kelompok = kelompok.id_kelompok INNER JOIN mahasiswa ON mahasiswa.id_mahasiswa = anggota_kelompok.id_mahasiswa INNER JOIN user ON mahasiswa.id_user = user.id_user WHERE user.id_user = ? AND mahasiswa.id_mahasiswa = anggota_kelompok.id_mahasiswa");
$q->execute([$_SESSION['id_user']]);
$laporan = $q->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php';?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php';?>

<!-- Topbar -->
<?php include '../layout/topbar.php';?>

<!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
 <div class="row mb-5">

    <!-- Card Status Mahasiswa -->
    <div class="col-xl-4 col-md-4">
        <div class="card py-2">
            <div class="card-body col">
                <p class="h6 text-gray-800">Status Verifikasi</p>
                <div class="h6 row justify-content-start align-items-center">
                    <div class="col">
                        <p class="mb-0 <?= $verif_text_class ?> "><?= $verif_label ?></p>
                    </div>
                    <div class="col">
                        <i class="<?= $verif_icon ?> fa-sm"></i>
                    </div>
                </div>
                <?php if ($verif_label === 'Ditolak') : ?>
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectionNoteModal">
                            Lihat Catatan Penolakan
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
 <div class="row mb-2">
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
                            <?php if($laporan){
                             $no = 1;
                            foreach($laporan as $l): ?>
                            <tr>
                                <td><?= htmlspecialchars($no++)?></td>
                                <td><?= htmlspecialchars(date('d-M-Y', strtotime($l['tanggal'])))?></td>
                                <td><?= htmlspecialchars($l['judul_laporan'])?></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                            </tr>
                            <?php endforeach;}else{ ?>
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
<?php include '../layout/footer.php';?>