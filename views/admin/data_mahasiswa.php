<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Mahasiswa';

// Get data mahasiswa
$mahasiswa = $pdo->query("SELECT * FROM mahasiswa m INNER JOIN prodi p ON m.id_prodi = p.id_prodi INNER JOIN fakultas f on m.id_fakultas = f.id_fakultas INNER JOIN tahun_akademik t ON m.id_tahun = t.id_tahun WHERE m.status = 'Diverifikasi Kaprodi' OR m.status = 'Diverifikasi' AND t.status = 'Aktif'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php'; ?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'; ?>

<!-- Content Row -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body pt-4 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
        <form action="">
            <div class="dropdown">
                <button class="btn btn-sm border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown button
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
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
                                <a href="hapus.php?nim=<?= htmlspecialchars($m['id_mahasiswa'])?>" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Hapus data mahasiswa <?= htmlspecialchars($m['nama_mahasiswa'])?>">Hapus</a>
                            </td>
                        </tr>   
                    <?php endforeach;
                    }else {?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data mahasiswa.</td>
                        </tr>  
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- footer -->
 <?php include '../layout/footer.php'; ?>