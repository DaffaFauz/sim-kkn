<?php
/**
 * Simple Filter Component
 * Basic filter component for any data with dropdown filters
 */

// Ensure variables are available
if (!isset($filterOptions)) {
    $filterOptions = [];
}
if (!isset($currentFilters)) {
    $currentFilters = [];
}
if (!isset($filterUrl)) {
    $filterUrl = '?';
}
?>

<!-- Simple Filter Bar -->
<div class="filter-bar mb-3">
    <div class="row">
        <?php foreach($filterOptions as $filterKey => $filterData): ?>
        <div class="col-md-<?= 12 / count($filterOptions) ?> mb-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="dropdown<?= ucfirst($filterKey) ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= isset($currentFilters[$filterKey]) ? htmlspecialchars($currentFilters[$filterKey]) : $filterData['label'] ?>
                </button>
                <div class="dropdown-menu w-100" aria-labelledby="dropdown<?= ucfirst($filterKey) ?>">
                    <a class="dropdown-item" href="<?= $filterUrl ?>">
                        <i class="fas fa-list"></i> <?= $filterData['allLabel'] ?? 'Semua' ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php foreach($filterData['options'] as $option): ?>
                    <a class="dropdown-item" href="<?= $filterUrl ?>&<?= $filterKey ?>=<?= urlencode($option['value']) ?>">
                        <?= htmlspecialchars($option['label']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if(!empty(array_filter($currentFilters))): ?>
    <div class="row mt-2">
        <div class="col-12">
            <div class="alert alert-info py-2">
                <small>
                    <strong>Filter Aktif:</strong>
                    <?php foreach($currentFilters as $key => $value): ?>
                        <?php if($value): ?>
                        <span class="badge badge-primary mr-1"><?= ucfirst($key) ?>: <?= htmlspecialchars($value) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <a href="<?= $filterUrl ?>" class="btn btn-sm btn-outline-secondary ml-2">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </small>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
