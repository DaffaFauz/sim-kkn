<?php
require_once '../../config/db.php';
require_once '../../includes/functions.php';
include_once '../../models/TahunAkademik.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Tahun Akademik';

$tahun_akademik = new TahunAkademik($pdo);
$tahun_akademik = $tahun_akademik->getAll();

?>

<!-- Head -->
<?php include '../layout/head.php';?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php';?>

<?php if(isset($_SESSION['msg'])): ?>
    <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
        <?= $_SESSION['msg'] ?>
    </div>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Tahun Ajaran</h6>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahTahunModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($tahun_akademik) {
                    $no = 1;
                    foreach($tahun_akademik as $row):
                        $id = (int)$row['id_tahun'];
                        $ta = htmlspecialchars($row['tahun_akademik']);
                        $status = htmlspecialchars($row['status']);?>
                        <tr>
                        <td><?= $no++?></td>
                        <td><?= $ta?></td>
                        <td><span class="badge <?php echo ($status === 'Aktif') ? 'badge-success' : 'badge-danger'; ?>"><?php echo ($status === 'Aktif') ? 'Aktif' : 'Tidak Aktif'; ?></span></td>
                        <td>
                        <form method="post" action="../../controllers/TahunController.php" style="display:inline;" onsubmit="return confirm('Ubah status tahun ajaran <?= addslashes($ta)?>?');">
                            <input type="hidden" name="id" value="<?= $id?>">
                            <button type="submit" name="ubah" class="btn btn-sm btn-warning">
                                <i class="fas fa-power-off"></i>
                                <?= ($status === 'Aktif') ? ' Nonaktifkan' : ' Aktifkan' ?>
                            </button>
                        </form>
                        <form action="../../controllers/TahunController.php" method="post" style="display:inline" onsubmit="return confirm('Hapus status tahun ajaran <?= addslashes($ta)?>?');">
                            <input type="hidden" name="id" value="<?= $id?>">
                            <button type="submit" name="hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>
                                Hapus
                            </button>
                        </form>
                        </td>
                        </tr>
                    <?php endforeach;
                } else {
                    ?><tr><td colspan="4" class="text-center">Tidak ada data tahun ajaran.</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal: Tambah Tahun Akademik -->
 <div class="modal fade" id="tambahTahunModal" tabindex="-1" role="dialog" aria-labelledby="tambahTahunModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="../../controllers/TahunController.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTahunModalLabel">Tambah Tahun Ajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik" placeholder="contoh: 2024/2025" required value="<?= date('Y').'/'.date('Y')+1; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- footer -->
    <?php include '../layout/footer.php';?>