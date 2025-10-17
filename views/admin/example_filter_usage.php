<?php
/**
 * Example: How to use the filter components
 * This file shows how to implement filters in your views
 */

// Example 1: Using the Lokasi Filter Component
?>

<!-- Example 1: Using Lokasi Filter Component -->
<?php
// In your view file, include the filter component like this:
// include 'components/lokasi_filter.php';
?>

<!-- Example 2: Using Simple Filter Component -->
<?php
// Setup filter options for simple filter
$filterOptions = [
    'kecamatan' => [
        'label' => 'Pilih Kecamatan',
        'allLabel' => 'Semua Kecamatan',
        'options' => [
            ['value' => 'Jakarta Selatan', 'label' => 'Jakarta Selatan'],
            ['value' => 'Jakarta Pusat', 'label' => 'Jakarta Pusat'],
            ['value' => 'Jakarta Utara', 'label' => 'Jakarta Utara'],
        ]
    ],
    'kabupaten' => [
        'label' => 'Pilih Kabupaten',
        'allLabel' => 'Semua Kabupaten',
        'options' => [
            ['value' => 'Jakarta', 'label' => 'Jakarta'],
            ['value' => 'Bogor', 'label' => 'Bogor'],
            ['value' => 'Depok', 'label' => 'Depok'],
        ]
    ]
];

$currentFilters = [
    'kecamatan' => isset($_GET['kecamatan']) ? $_GET['kecamatan'] : '',
    'kabupaten' => isset($_GET['kabupaten']) ? $_GET['kabupaten'] : '',
];

$filterUrl = '?';
?>

<!-- Include the simple filter -->
<?php include 'components/simple_filter.php'; ?>

<!-- Example 3: Custom Filter Implementation -->
<div class="custom-filter mb-3">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">Custom Filter Example</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row">
                <div class="col-md-4">
                    <select name="kecamatan" class="form-control">
                        <option value="">Pilih Kecamatan</option>
                        <option value="Jakarta Selatan" <?= (isset($_GET['kecamatan']) && $_GET['kecamatan'] == 'Jakarta Selatan') ? 'selected' : '' ?>>Jakarta Selatan</option>
                        <option value="Jakarta Pusat" <?= (isset($_GET['kecamatan']) && $_GET['kecamatan'] == 'Jakarta Pusat') ? 'selected' : '' ?>>Jakarta Pusat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="kabupaten" class="form-control">
                        <option value="">Pilih Kabupaten</option>
                        <option value="Jakarta" <?= (isset($_GET['kabupaten']) && $_GET['kabupaten'] == 'Jakarta') ? 'selected' : '' ?>>Jakarta</option>
                        <option value="Bogor" <?= (isset($_GET['kabupaten']) && $_GET['kabupaten'] == 'Bogor') ? 'selected' : '' ?>>Bogor</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="?" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Example 4: Advanced Filter with Date Range -->
<div class="advanced-filter mb-3">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">Advanced Filter Example</h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row">
                <div class="col-md-3">
                    <label>From Date:</label>
                    <input type="date" name="date_from" class="form-control" value="<?= isset($_GET['date_from']) ? $_GET['date_from'] : '' ?>">
                </div>
                <div class="col-md-3">
                    <label>To Date:</label>
                    <input type="date" name="date_to" class="form-control" value="<?= isset($_GET['date_to']) ? $_GET['date_to'] : '' ?>">
                </div>
                <div class="col-md-3">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" <?= (isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                        <a href="?" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
