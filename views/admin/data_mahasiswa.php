<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
require_once '../../models/Mahasiswa.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Mahasiswa';

$mahasiswa = new Mahasiswa($pdo);

// Prodi filter
$prodiFilterButton = $pdo->query("SELECT DISTINCT * FROM mahasiswa LEFT JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi")->fetchAll(PDO::FETCH_ASSOC);
$statusFilterButton = ['Diverifikasi', 'Diverifikasi Kaprodi', 'Ditolak'];

$prodi = isset($_GET['prodi']) ? trim($_GET['prodi']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

if(!empty($prodi) || !empty($status)){
    $mahasiswa = $mahasiswa->filter($prodi, $status);
} else {
    $mahasiswa = $mahasiswa->getAll();
}


?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

<?php if(isset($_SESSION['msg'])): ?>
    <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
        <?= $_SESSION['msg'] ?>
    </div>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body pt-4 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
        <form action="data_mahasiswa.php" method="get" class="d-flex justify-content-end align-items-center">
           <div class="form-group mr-2">
                <select name="prodi" class="form-control form-control-sm">
                    <option value="">Pilih Prodi</option>
                    <?php foreach($prodiFilterButton as $p): ?>
                    <option value="<?= htmlspecialchars($p['nama_prodi'])?>" <?= (isset($_GET['prodi']) && $_GET['prodi'] == $p['nama_prodi']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nama_prodi'])?></option>
                    <?php endforeach;?>
                </select>
            </div>
           <div class="form-group mr-2">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Pilih Status Mahasiswa</option>
                    <?php foreach($statusFilterButton as $s): ?>
                    <option value="<?= htmlspecialchars($s)?>" <?= (isset($_GET['status']) && $_GET['status'] == $s) ? 'selected' : '' ?>><?= htmlspecialchars($s)?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </form>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($mahasiswa){
                    $no = 1;
                    foreach($mahasiswa as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($no++)?></td>
                            <td><?= htmlspecialchars($m['nim'])?></td>
                            <td><?= htmlspecialchars($m['nama_mahasiswa'])?></td>
                            <td><?= htmlspecialchars($m['nama_prodi'])?></td>
                            <td><?= htmlspecialchars($m['kelas'])?></td>
                            <td><?= htmlspecialchars($m['alamat'])?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i> Lihat</button>
                                <button type="button" class="btn btn-sm btn-warning ml-1" data-toggle="modal" data-target="#exampleModalEdit"><i class="fas fa-edit"></i>Edit</button>
                                <form action="../../controllers/MahasiswaController.php" method="post" class="d-inline">
                                    <input type="hidden" name="id_mahasiswa" value="<?= $m['id_mahasiswa'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Hapus data Mahasiswa ini?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>   
                    <?php endforeach;
                    }else {?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data mahasiswa.</td>
                        </tr>  
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- footer -->
 <?php include '../layout/footer.php'; ?>
  <script>
    $('DOMContentLoaded').ready(function () {
        $('select[name="prodi"]').on('change', function () {
            $('form[method="get"]').submit();
        });
        $('select[name="status"]').on('change', function () {
            $('form[method="get"]').submit();
        })
    })
</script>