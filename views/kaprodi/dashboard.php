<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
checkLogin();
checkRole(['Kaprodi']);
$pageTitle = 'Dashboard Kaprodi';

// Query Untuk Mendapatkan Data Mahasiswa sesuai dengan Prodi yang Diampu Kaprodi
$stmt = $pdo->prepare("SELECT m.*, p.nama_prodi FROM mahasiswa m INNER JOIN prodi p ON m.id_prodi = p.id_prodi INNER JOIN dosen d ON d.id_prodi = p.id_prodi INNER JOIN user u ON u.id_user = d.id_user WHERE u.id_user = ? AND d.id_prodi = p.id_prodi AND m.status = 'Pending'");
$stmt->execute([$_SESSION['id_user']]);
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <!-- Content Column -->
    <div class="col mb-4">

        <!-- Page Heading Laporan Kegiatan Harian Kelompok -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h5 mb-0 text-gray-800">Data Mahasiswa Belum Diverifikasi</h1>
        </div>
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Data</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama Mahasiswa</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($mahasiswa){
                            $no = 1;
                         foreach($mahasiswa as $m): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($no++)?></th>
                            <td><?= htmlspecialchars($m['nim']); ?></td>
                            <td><?= htmlspecialchars($m['nama_mahasiswa']);?></td>
                            <td><?= htmlspecialchars($m['kelas']);?></td>
                            <td>Desa <?= htmlspecialchars($m['status']);?></td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $m['id_mahasiswa']?>"><i class="fas fa-eye"></i> Lihat Detail</button></td>
                        </tr>
                        <?php endforeach;}else{ ?>
                            <td colspan="6" class="text-center">Tidak ada mahasiswa yang belum diverifikasi.</td>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- End of Content Column -->
</div>

<!-- Modal lihat detail -->
 <?php foreach($mahasiswa as $m):?>
 <div class="modal fade" id="exampleModal<?= htmlspecialchars($m['id_mahasiswa']);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>NIM: <input type="text" class="form-control"  value="<?= htmlspecialchars($m['nim']) ?>" readonly disabled></p>
                <p>Nama Mahasiswa: <input type="text" class="form-control"  value="<?= htmlspecialchars($m['nama_mahasiswa'])?>" readonly disabled></p>
                <p>Kelas: <input type="text" class="form-control"  value="<?= htmlspecialchars($m['kelas'])?>" readonly disabled></p>
                <p>Status Pembayaran: <textarea name="" id="" class="form-control" rows="5" readonly disabled><?= htmlspecialchars($m['status_pembayaran'])?></textarea></p>
                <p>Bukti Pembayaran: <img src="" alt=""></p>
            </div>
            <div class="modal-footer">
                <form action="" method="post">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                    <button type="submit" class="btn btn-success">Verifikasi</button>
                </form>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Tutup</button>
            </div> 
        </div>
    </div>
</div>
<?php endforeach;?>

<!-- footer -->
<?php include '../layout/footer.php'; ?>