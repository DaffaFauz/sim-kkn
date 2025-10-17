<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
include_once '../../models/Lokasi.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Lokasi';

// Get data Lokasi
$lokasi = new Lokasi($pdo);
    $lokasi = $lokasi->getAll();

// Get data Kecamatan
$kecamatan = new Lokasi($pdo);
// $kecamatan = $kecamatan->getByKecamatan();
$kecamatanFilterButton = $pdo->query("SELECT DISTINCT nama_kecamatan FROM lokasi GROUP BY nama_kecamatan")->fetchAll(PDO::FETCH_ASSOC);

// Get data Kabupaten
$kabupaten = new Lokasi($pdo);
// $kabupaten = $kabupaten->getByKabupaten();
$kabupatenFilterButton = $pdo->query("SELECT DISTINCT nama_kabupaten FROM lokasi GROUP BY nama_kabupaten")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php';?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php';?>

<!-- Topbar -->
<?php include '../layout/topbar.php';?>

<?php if(isset($_SESSION['msg'])): ?>
    <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
        <?= $_SESSION['msg'] ?>
    </div>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-sm-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Lokasi</h6>
            </div>
            <div class="col-sm-9">
                <div class="justify-content-end d-flex">
                    <form action="../../controllers/LokasiController.php" method="GET" class="mr-2">
                        <div class="row m-0">
                            <div class="col-6 justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pilih Kecamatan
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php foreach($kecamatanFilterButton as $ke): ?>
                                        <button type="submit" class="dropdown-item" name="kecamatan" value="<?= htmlspecialchars($ke['nama_kecamatan'])?>"><?= htmlspecialchars($ke['nama_kecamatan'])?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="dropdown">
                                    <button class="btn btn-sm border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pilih Kabupaten
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php foreach($kabupatenFilterButton as $ka): ?>
                                        <button type="submit" class="dropdown-item"><?= htmlspecialchars($ka['nama_kabupaten'])?></a>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="m-0 font-weight-bold btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahLokasiModal">
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
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Kabupaten</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($lokasi) {
                        foreach($lokasi as $row):?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_desa']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kecamatan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kabupaten']) ?></td>
                        <td><button type = "submit" class="btn btn-sm btn-warning btn-edit" 
                                data-toggle="modal" data-target="#editLokasiModal<?= $row['id_lokasi'] ?>">
                                <i class="fas fa-edit">Edit </i></button>
                                <form action="../../controllers/LokasiController.php" method="post" class="d-inline">
                                    <input type="hidden" name="id_lokasi" value="<?= $row['id_lokasi'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" name="hapus" onclick="return confirm('Hapus data lokasi ini?')">Hapus</button>
                                </form>
                                </td>
                    </tr>
                    <?php 
                        endforeach;}else{
                        echo '<tr><td colspan="4" class="text-center">No data available</td></tr>';
                    } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Tambah Lokasi -->
 <div class="modal fade" id="tambahLokasiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../../controllers/LokasiController.php" method="post">
                    <div class="form-group">
                        <label for="nama_desa">Nama Desa</label>
                        <input type="text" class="form-control" id="nama_desa" name="nama_desa" placeholder="Masukkan nama desa">
                    </div>
                    <div class="form-group">
                        <label for="nama_kecamatan">Nama Kecamatan</label>
                        <input type="text" class="form-control" id="nama_kecamatan" name="nama_kecamatan" placeholder="Masukkan nama kecamatan">
                    </div>
                    <div class="form-group">
                        <label for="nama_kabupaten">Nama Kabupaten</label>
                        <input type="text" class="form-control" id="nama_kabupaten" name="nama_kabupaten" placeholder="Masukkan nama kabupaten">
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

 <!-- Modal: Edit Lokasi -->
<?php if (!empty($lokasi)) : ?>
    <?php foreach ($lokasi as $row) : ?>
        <div class="modal fade" id="editLokasiModal<?= $row['id_lokasi'] ?>" tabindex="-1" role="dialog" aria-labelledby="editLokasiLabel<?= $row['id_lokasi'] ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="../../controllers/LokasiController.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLokasiLabel<?= $row['id_lokasi'] ?>">Edit Lokasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_lokasi" value="<?= $row['id_lokasi'] ?>">
                            <div class="form-group">
                                <label for="nama_desa_<?= $row['id_lokasi'] ?>">Nama Desa</label>
                                <input type="text" class="form-control" id="nama_desa_<?= $row['id_lokasi'] ?>" name="nama_desa" value="<?= htmlspecialchars($row['nama_desa']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_kecamatan_<?= $row['id_lokasi'] ?>">Nama Kecamatan</label>
                                <input type="text" class="form-control" id="nama_kecamatan_<?= $row['id_lokasi'] ?>" name="nama_kecamatan" value="<?= htmlspecialchars($row['nama_kecamatan']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_kabupaten_<?= $row['id_lokasi'] ?>">Nama Kabupaten</label>
                                <input type="text" class="form-control" id="nama_kabupaten_<?= $row['id_lokasi'] ?>" name="nama_kabupaten" value="<?= htmlspecialchars($row['nama_kabupaten']) ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>



<!-- Footer -->
 <?php include '../layout/footer.php';?>