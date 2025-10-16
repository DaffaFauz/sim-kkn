<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Dosen';

// Get data dosen
$dosen = $pdo->query("SELECT * FROM dosen d INNER JOIN prodi p ON d.id_prodi = p.id_prodi INNER JOIN user u ON d.id_user = u.id_user ORDER BY d.nidn ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

 <!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Data Dosen</h1>

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

<!-- footer -->
 <?php include '../layout/footer.php'; ?>