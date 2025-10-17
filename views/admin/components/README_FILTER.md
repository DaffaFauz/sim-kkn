# Filter Components Documentation

This directory contains reusable filter components for the admin panel.

## Components Available

### 1. `lokasi_filter.php`
A specialized filter component for Lokasi (Location) data with Kecamatan and Kabupaten filters.

**Usage:**
```php
<?php
// In your view file
include 'components/lokasi_filter.php';
?>
```

**Required Variables:**
- `$kecamatanList` - Array of kecamatan options
- `$kabupatenList` - Array of kabupaten options  
- `$filter_kecamatan` - Current kecamatan filter value
- `$filter_kabupaten` - Current kabupaten filter value
- `$lokasi` - Array of lokasi data (for summary)

### 2. `simple_filter.php`
A generic filter component that can be used for any data with dropdown filters.

**Usage:**
```php
<?php
$filterOptions = [
    'kecamatan' => [
        'label' => 'Pilih Kecamatan',
        'allLabel' => 'Semua Kecamatan',
        'options' => [
            ['value' => 'value1', 'label' => 'Label 1'],
            ['value' => 'value2', 'label' => 'Label 2'],
        ]
    ]
];

$currentFilters = [
    'kecamatan' => isset($_GET['kecamatan']) ? $_GET['kecamatan'] : '',
];

$filterUrl = '?';
include 'components/simple_filter.php';
?>
```

## Implementation Examples

### Basic Filter Implementation

```php
<?php
// 1. Get filter parameters
$filter_kecamatan = isset($_GET['kecamatan']) ? $_GET['kecamatan'] : null;
$filter_kabupaten = isset($_GET['kabupaten']) ? $_GET['kabupaten'] : null;

// 2. Get filtered data
if($filter_kecamatan || $filter_kabupaten){
    $data = $model->filter($filter_kecamatan, $filter_kabupaten);
} else {
    $data = $model->getAll();
}

// 3. Get filter options
$kecamatanList = $model->getKecamatan();
$kabupatenList = $model->getKabupaten();
?>

<!-- 4. Include filter component -->
<?php include 'components/lokasi_filter.php'; ?>

<!-- 5. Display filtered data -->
<table class="table">
    <?php foreach($data as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['field']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
```

### Model Methods Required

```php
class YourModel {
    public function getAll() {
        // Return all data
    }
    
    public function filter($kecamatan = null, $kabupaten = null) {
        // Return filtered data
    }
    
    public function getKecamatan() {
        // Return distinct kecamatan for dropdown
    }
    
    public function getKabupaten() {
        // Return distinct kabupaten for dropdown
    }
}
```

### Controller Handling

```php
// Handle filter requests
if(isset($_GET['kecamatan']) || isset($_GET['kabupaten'])){
    $kecamatan = isset($_GET['kecamatan']) ? trim($_GET['kecamatan']) : null;
    $kabupaten = isset($_GET['kabupaten']) ? trim($_GET['kabupaten']) : null;
    
    // Redirect back to view with filter parameters
    $redirectUrl = '../views/admin/your_view.php';
    if($kecamatan || $kabupaten){
        $redirectUrl .= '?' . http_build_query(array_filter([
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten
        ]));
    }
    header('Location: ' . $redirectUrl);
    exit;
}
```

## Features

### Filter Components Include:
- ✅ Dropdown filters with "All" options
- ✅ Active filter display with badges
- ✅ Clear filter functionality
- ✅ Filter status indicators
- ✅ Data summary with record counts
- ✅ Responsive design
- ✅ Bootstrap styling
- ✅ FontAwesome icons

### URL Structure:
- No filters: `your_page.php`
- Single filter: `your_page.php?kecamatan=Jakarta%20Selatan`
- Multiple filters: `your_page.php?kecamatan=Jakarta%20Selatan&kabupaten=Jakarta`

## Customization

### Styling
All components use Bootstrap classes and can be customized by:
- Modifying CSS classes in the component files
- Adding custom CSS for specific styling needs
- Using Bootstrap utility classes

### Functionality
Components can be extended by:
- Adding more filter options
- Implementing search functionality
- Adding date range filters
- Including export functionality

## Best Practices

1. **Always validate filter parameters** in your model methods
2. **Use prepared statements** to prevent SQL injection
3. **Sanitize output** with `htmlspecialchars()`
4. **Handle empty results** gracefully
5. **Provide clear feedback** when filters are active
6. **Maintain filter state** during CRUD operations
7. **Use consistent naming** for filter parameters
8. **Test with various filter combinations**

## Troubleshooting

### Common Issues:
1. **Filters not working**: Check if model methods are properly implemented
2. **Empty dropdowns**: Verify data is being fetched correctly
3. **URL parameters not preserved**: Ensure proper URL building in controller
4. **Styling issues**: Check Bootstrap CSS is loaded
5. **JavaScript errors**: Verify Bootstrap JS is loaded for dropdowns

### Debug Tips:
- Use `var_dump()` to check filter parameters
- Check database queries with proper logging
- Verify URL parameters in browser developer tools
- Test with different filter combinations
