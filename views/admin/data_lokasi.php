<?php
include_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Lokasi';

// Get data Lokasi
$lokasi = $pdo->query("SELECT * FROM lokasi")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Head -->
<?php include '../layout/head.php';?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php';?>

<!-- Topbar -->
<?php include '../layout/topbar.php';?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body py-3">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-sm-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Lokasi</h6>
            </div>
            <div class="col-sm-9">
                <div class="justify-content-end d-flex">
                    <form action="" method="GET" class="mr-2">
                        <div class="row m-0">
                            <div class="col-6 justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pilih Kecamatan
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?php foreach($lokasi as $ke): ?>
                                        <button type="submit" class="dropdown-item"><?= htmlspecialchars($ke['nama_kecamatan'])?></a>
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
                                        <?php foreach($lokasi as $ka): ?>
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
                            <a href="../../modules/lokasi/hapus.php?id=" class="btn btn-sm btn-danger">Hapus</td>
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


<!-- Footer -->
 <?php include '../layout/footer.php';?>