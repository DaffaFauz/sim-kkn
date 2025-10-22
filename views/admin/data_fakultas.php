<?php
require_once '../../config/db.php';
include_once '../../models/fakultas.php'; 
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Fakultas';

$fakultasModel = new Fakultas($pdo);
$fakultas = $fakultasModel->getAll();

?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Fakultas</h1>

<?php if(isset($_SESSION['msg'])): ?>
<div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
    <?= $_SESSION['msg'] ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>
<?php unset($_SESSION['msg']); ?>

<!-- Tabel Data Dosen -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Fakultas</h6>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahFakultasModal">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Fakultas</th>
                        <th>Nama Fakultas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($fakultas){
                    $no = 1;
                    foreach($fakultas as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($no++) ?></td>
                        <td><?= htmlspecialchars($f['kode_fakultas']) ?></td>
                        <td><?= htmlspecialchars($f['nama_fakultas']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#editFakultasModal<?= $f['id_fakultas'] ?>">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <form action="../../controllers/FakultasController.php" method="post" class="d-inline">
                                <input type="hidden" name="id_fakultas" value="<?= $f['id_fakultas'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Hapus data dosen ini?')">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    endforeach;} else {
                        echo '<tr><td colspan="4" class="text-center">Data fakultas kosong.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Fakultas -->
<div class="modal fade" id="tambahFakultasModal" tabindex="-1" role="dialog" aria-labelledby="tambahFakultasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahFakultasLabel">Tambah Fakultas</h5>
            </div>
            <div class="modal-body">
                <form action="../../controllers/FakultasController.php" method="post">
                    <div class="form-group">
                        <label for="kode_fakultas">Kode Fakultas</label>
                        <input type="text" class="form-control" id="kode_fakultas" name="kode_fakultas" placeholder="Masukkan Kode Fakultas">
                    </div>
                    <div class="form-group">
                        <label for="nama_fakultas">Nama Fakultas</label>
                        <input type="text" class="form-control" id="nama_fakultas" name="nama_fakultas" placeholder="Masukkan Nama Fakultas">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Fakultas -->
<?php foreach($fakultas as $f): ?>
<div class="modal fade" id="editFakultasModal<?= $f['id_fakultas'] ?>" tabindex="-1" role="dialog" aria-labelledby="editFakultasLabel<?= $f['id_fakultas'] ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFakultasLabel<?= $f['id_fakultas'] ?>">Edit Fakultas</h5>
            </div>
            <div class="modal-body">
                <form action="../../controllers/FakultasController.php" method="post">
                    <input type="hidden" name="id_fakultas" value="<?= $f['id_fakultas'] ?>">
                    <div class="form-group">
                        <label for="kode_fakultas_<?= $f['id_fakultas'] ?>">Kode Fakultas</label>
                        <input type="text" class="form-control" id="kode_fakultas_<?= $f['id_fakultas'] ?>" name="kode_fakultas" value="<?= htmlspecialchars($f['kode_fakultas']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_fakultas_<?= $f['id_fakultas'] ?>">Nama Fakultas</label>
                        <input type="text" class="form-control" id="nama_fakultas_<?= $f['id_fakultas'] ?>" name="nama_fakultas" value="<?= htmlspecialchars($f['nama_fakultas']) ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="ubah">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- footer -->
 <?php include '../layout/footer.php'; ?>