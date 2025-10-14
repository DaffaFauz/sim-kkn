<?php
require_once '..\..\auth\check_login.php';
require_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);


require_once '../../config/db.php';
$jml_mahasiswa = $pdo->query("SELECT COUNT(*) FROM mahasiswa INNER JOIN tahun_akademik ON tahun_akademik.id_tahun = mahasiswa.id_tahun WHERE tahun_akademik.status = 'Aktif'")->fetchColumn();
$jml_dosen = $pdo->query("SELECT COUNT(*) FROM dosen INNER JOIN user ON dosen.id_user = user.id_user WHERE user.role = 'Dosen Pembimbing'")->fetchColumn();
$jml_kelompok = $pdo->query("SELECT COUNT(*) FROM kelompok INNER JOIN tahun_akademik ON tahun_akademik.id_tahun = kelompok.id_tahun WHERE tahun_akademik.status = 'Aktif'")->fetchColumn();
$jml_lokasi = $pdo->query("SELECT COUNT(*) FROM lokasi")->fetchColumn();
$pageTitle = 'Dashboard Admin';

// Mendapat data laporan
$laporan = $pdo->query("SELECT * FROM laporan_harian INNER JOIN kelompok ON laporan_harian.id_kelompok = kelompok.id_kelompok INNER JOIN lokasi ON kelompok.id_lokasi = lokasi.id_lokasi ORDER BY tanggal DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($jml_mahasiswa) 
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($jml_dosen)
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
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= htmlspecialchars($jml_kelompok)
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($jml_lokasi)
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
                        <?php if($laporan){
                         foreach($laporan as $l): ?>
                        <tr>
                            <th scope="row">1</th>
                            <td><?= htmlspecialchars(date('d-M-Y', strtotime($l['tanggal']))); ?></td>
                            <td><?= htmlspecialchars($l['nama_kelompok']);?></td>
                            <td><?= htmlspecialchars($l['judul_laporan']);?></td>
                            <td>Desa <?= htmlspecialchars($l['nama_desa']);?></td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $l['id_laporan']?>"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                        </tr>
                        <?php endforeach;}else{ ?>
                            <td colspan="6" class="text-center">Belum ada laporan kegiatan harian yang tersedia.</td>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- End of Content Column -->
</div>

<!-- Modal lihat detail -->
 <?php foreach($laporan as $l):?>
 <div class="modal fade" id="exampleModal<?= htmlspecialchars($l['id_laporan']);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tanggal: <input type="text" class="form-control"  value="<?= htmlspecialchars(date('d-M-Y', strtotime($l['tanggal']))) ?>" readonly disabled></p>
                <p>Kelompok: <input type="text" class="form-control"  value="<?= htmlspecialchars($l['nama_kelompok'])?>" readonly disabled></p>
                <p>Kegiatan: <input type="text" class="form-control"  value="<?= htmlspecialchars($l['judul_laporan'])?>" readonly disabled></p>
                <p>Isi: <textarea name="" id="" class="form-control" rows="5" readonly disabled><?= htmlspecialchars($l['isi_laporan'])?></textarea></p>
                <p>Lokasi: <input type="text" class="form-control"  value="Desa A" readonly disabled></p>
                <p>Dokumentasi: <img src="" alt=""></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div> 
        </div>
    </div>
</div>
<?php endforeach;?>



<!-- Footer -->
<?php include '../layout/footer.php'; ?>