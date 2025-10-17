<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Dosen';

// Get data dosen
$dosen = $pdo->query("SELECT * FROM dosen d INNER JOIN prodi p ON d.id_prodi = p.id_prodi INNER JOIN user u ON d.id_user = u.id_user ORDER BY d.nidn ASC")->fetchAll(PDO::FETCH_ASSOC);
$prodi = $pdo->query("SELECT * FROM prodi")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Dosen</h1>

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
        <h6 class="m-0 font-weight-bold text-primary">Data Dosen</h6>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahDosenModal">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIDN</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($dosen){
                    $no = 1;
                    foreach($dosen as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nidn']) ?></td>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td>Dosen <?= htmlspecialchars($row['nama_prodi']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#editDosenModal<?= $row['id_dosen'] ?>">
                                <i class="fas fa-edit"></i>
                                Edit
                            </button>
                            <a href="../../modules/dosen/hapus.php?id=<?= urlencode($row['id_dosen']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data dosen ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php
                    endforeach;} else {
                        echo '<tr><td colspan="4" class="text-center">Belum ada data dosen.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Dosen -->
<div class="modal fade" id="tambahDosenModal" tabindex="-1" role="dialog" aria-labelledby="tambahDosenLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDosenLabel">Tambah Dosen</h5>
            </div>
            <div class="modal-body">
                <form action="../../controllers/DosenController.php" method="post">
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" id="nidn" name="nidn" placeholder="Masukkan NIDN">
                    </div>
                    <div class="form-group">
                        <label for="nama_dosen">Nama Dosen</label>
                        <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" placeholder="Masukkan Nama Dosen">
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Jurusan</label>
                        <select class="form-control" id="id_prodi" name="id_prodi">
                            <option selected disabled value="">-- Pilih Jurusan --</option>
                            <?php foreach($prodi as $row): ?>
                            <option value="<?= $row['id_prodi'] ?>"><?= $row['nama_prodi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select class="form-control" id="jabatan" name="jabatan">
                            <option value="Dosen">Dosen</option>
                            <option value="Admin">Admin</option>
                            <option value="Kaprodi">Kaprodi</option>
                            <option value="Pembimbing">Pembimbing</option>
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

<!-- footer -->
 <?php include '../layout/footer.php'; ?>