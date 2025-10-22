<?php
require_once '../../config/db.php';
include_once '../../models/prodi.php'; 
include_once '../../models/fakultas.php'; 
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Prodi';

$prodiModel = new Prodi($pdo);
$fakultasModel = new Fakultas($pdo);

$FakultasFilterButton = $fakultasModel->getAll();

$fakultas = $fakultasModel->getAll();


if(isset($_GET['filter']) && !empty($_GET['filter'])){
    $nama_fakultas = $_GET['filter'];
    $prodi = $prodiModel->filter($nama_fakultas);
} else {
    $prodi = $prodiModel->getAll();
}
?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Prodi</h1>

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
        <h6 class="m-0 font-weight-bold text-primary">Data Prodi</h6>
        <div class="col-sm-9 d-flex justify-content-end align-items-center">
            <div class="justify-content-end d-flex">
                <form action="data_prodi.php" method="get" class="d-flex justify-content-end align-items-center">
                    <div class="form-group mr-2">
                        <select name="filter" class="form-control form-control-sm">
                            <option value="">Semua Fakultas</option>
                            <?php foreach($FakultasFilterButton as $f): ?>
                            <option value="<?= htmlspecialchars($f['nama_fakultas'])?>" <?= (isset($_GET['filter']) && $_GET['filter'] == $f['nama_fakultas']) ? 'selected' : '' ?>><?= htmlspecialchars($f['nama_fakultas'])?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
                <div class="form-group">
                    <button type="button" class="m-0 btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahProdiModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Prodi</th>
                        <th>Nama Prodi</th>
                        <th>Nama Fakultas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($prodi && count($prodi) > 0){
                    $no = 1;
                    foreach($prodi as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($no++) ?></td>
                        <td><?= htmlspecialchars($p['kode_prodi']) ?></td>
                        <td><?= htmlspecialchars($p['nama_prodi']) ?></td>
                        <td><?= htmlspecialchars($p['nama_fakultas']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#editProdiModal<?= $p['id_prodi'] ?>">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <form action="../../controllers/ProdiController.php" method="post" class="d-inline">
                                <input type="hidden" name="id_prodi" value="<?= $p['id_prodi'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Hapus data prodi ini?')">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    endforeach;} else {
                        echo '<tr><td colspan="5" class="text-center">Data prodi kosong.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Prodi -->
<div class="modal fade" id="tambahProdiModal" tabindex="-1" role="dialog" aria-labelledby="tambahProdiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahProdiLabel">Tambah Prodi</h5>
            </div>
            <div class="modal-body">
                <form action="../../controllers/ProdiController.php" method="post">
                    <div class="form-group">
                        <label for="kode_prodi">Kode Prodi</label>
                        <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" placeholder="Masukkan Kode Prodi">
                    </div>
                    <div class="form-group">
                        <label for="nama_prodi">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" placeholder="Masukkan Nama Prodi">
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Nama Fakultas</label>
                        <select name="id_fakultas" class="form-control" id="fakultas">
                            <option value="">-- Pilih Fakultas --</option>
                            <?php foreach($fakultas as $f): ?>
                            <option value="<?= $f['id_fakultas'] ?>"><?= htmlspecialchars($f['nama_fakultas']) ?></option>
                            <?php endforeach; ?>
                        </select>
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

<!-- Modal: Edit Prodi -->
<?php foreach($prodi as $p): ?>
<div class="modal fade" id="editProdiModal<?= $p['id_prodi'] ?>" tabindex="-1" role="dialog" aria-labelledby="editProdiLabel<?= $p['id_prodi'] ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProdiLabel<?= $p['id_prodi'] ?>">Edit Prodi</h5>
            </div>
            <div class="modal-body">
                <form action="../../controllers/ProdiController.php" method="post">
                    <input type="hidden" name="id_prodi" value="<?= $p['id_prodi'] ?>">
                    <div class="form-group">
                        <label for="kode_prodi_<?= $p['id_prodi'] ?>">Kode Prodi</label>
                        <input type="text" class="form-control" id="kode_prodi_<?= $p['id_prodi'] ?>" name="kode_prodi" value="<?= htmlspecialchars($p['kode_prodi']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_prodi_<?= $p['id_prodi'] ?>">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi_<?= $p['id_prodi'] ?>" name="nama_prodi" value="<?= htmlspecialchars($p['nama_prodi']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="fakultas_<?= $p['id_prodi'] ?>">Nama Fakultas</label>
                        <select name="id_fakultas" class="form-control" id="fakultas_<?= $p['id_prodi'] ?>">
                            <?php foreach($fakultas as $f): ?>
                            <option value="<?= $f['id_fakultas'] ?>" <?= ($p['id_fakultas'] == $f['id_fakultas']) ? 'selected' : '' ?>><?= htmlspecialchars($f['nama_fakultas']) ?></option>
                            <?php endforeach; ?>
                        </select>
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

<!-- script -->
 <script>
    $('DOMContentLoaded').ready(function() {
        $('select[name="filter"]').on('change', function () {
            $('form[method="get"]').submit();
        });

    });
 </script>