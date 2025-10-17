<?php
/**
 * Lokasi Filter Component
 * Reusable filter component for Lokasi data
 */

// Ensure variables are available
if (!isset($kecamatanList)) {
    $kecamatanList = [];
}
if (!isset($kabupatenList)) {
    $kabupatenList = [];
}
if (!isset($filter_kecamatan)) {
    $filter_kecamatan = null;
}
if (!isset($filter_kabupaten)) {
    $filter_kabupaten = null;
}
?>

<!-- Filter Controls -->
<div class="card mb-3">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter"></i> Filter Lokasi
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Filter by Kecamatan:</label>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="dropdownKecamatan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $filter_kecamatan ? htmlspecialchars($filter_kecamatan) : 'Pilih Kecamatan' ?>
                    </button>
                    <div class="dropdown-menu w-100" aria-labelledby="dropdownKecamatan">
                        <a class="dropdown-item" href="?kabupaten=<?= $filter_kabupaten ? urlencode($filter_kabupaten) : '' ?>">
                            <i class="fas fa-list"></i> Semua Kecamatan
                        </a>
                        <div class="dropdown-divider"></div>
                        <?php foreach($kecamatanList as $ke): ?>
                        <a class="dropdown-item" href="?kecamatan=<?= urlencode($ke['nama_kecamatan']) ?><?= $filter_kabupaten ? '&kabupaten=' . urlencode($filter_kabupaten) : '' ?>">
                            <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($ke['nama_kecamatan']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Filter by Kabupaten:</label>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="dropdownKabupaten" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $filter_kabupaten ? htmlspecialchars($filter_kabupaten) : 'Pilih Kabupaten' ?>
                    </button>
                    <div class="dropdown-menu w-100" aria-labelledby="dropdownKabupaten">
                        <a class="dropdown-item" href="?kecamatan=<?= $filter_kecamatan ? urlencode($filter_kecamatan) : '' ?>">
                            <i class="fas fa-list"></i> Semua Kabupaten
                        </a>
                        <div class="dropdown-divider"></div>
                        <?php foreach($kabupatenList as $ka): ?>
                        <a class="dropdown-item" href="?kabupaten=<?= urlencode($ka['nama_kabupaten']) ?><?= $filter_kecamatan ? '&kecamatan=' . urlencode($filter_kecamatan) : '' ?>">
                            <i class="fas fa-city"></i> <?= htmlspecialchars($ka['nama_kabupaten']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Actions:</label>
                <div class="d-flex gap-2">
                    <?php if($filter_kecamatan || $filter_kabupaten): ?>
                    <a href="?" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-times"></i> Clear All
                    </a>
                    <?php endif; ?>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahLokasiModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Status -->
<?php if($filter_kecamatan || $filter_kabupaten): ?>
<div class="alert alert-info mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong><i class="fas fa-info-circle"></i> Filter Aktif:</strong>
            <?php if($filter_kecamatan): ?>
                <span class="badge badge-primary ml-2">
                    <i class="fas fa-map-marker-alt"></i> Kecamatan: <?= htmlspecialchars($filter_kecamatan) ?>
                </span>
            <?php endif; ?>
            <?php if($filter_kabupaten): ?>
                <span class="badge badge-primary ml-2">
                    <i class="fas fa-city"></i> Kabupaten: <?= htmlspecialchars($filter_kabupaten) ?>
                </span>
            <?php endif; ?>
        </div>
        <a href="?" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times"></i> Clear All Filters
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Filter Summary -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card border-left-info">
            <div class="card-body py-2">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            <i class="fas fa-database"></i> Data Summary
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            <?php 
                            $totalRecords = is_array($lokasi) ? count($lokasi) : 0;
                            echo "Total Records: " . $totalRecords;
                            if($filter_kecamatan || $filter_kabupaten) {
                                echo " (Filtered)";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
