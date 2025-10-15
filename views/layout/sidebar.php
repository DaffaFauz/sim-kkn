<?php
//$role = $_SESSION['role']; // Default to 'guest' if not set

$current_file = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
function is_active_file($names)
{
    global $current_file;
    $names = (array)$names;
    return in_array($current_file, $names, true);
}

$master_pages = ['dashboard.php', 'data_mahasiswa.php', 'data_dosen.php', 'data_pembimbing.php', 'data_kaprodi.php', 'data_fakultas.php', 'data_prodi.php', 'data_kelompok.php', 'data_lokasi.php', 'data_tahun-akademik.php', 'kelompok.php',  'laporan_kegiatan.php', 'laporan_akhir.php', 'laporan_nilai.php', 'verifikasi_mahasiswa.php'];
$master_open = is_active_file($master_pages);
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">KKN MU</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= is_active_file('dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Jika role Admin, maka tampilkan menu ini -->
     <?php 
     if($_SESSION['role'] === 'Admin'){?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Master
        </div>

        <!-- Menu Data Mahasiswa -->
        <li class="nav-item <?= is_active_file('data_mahasiswa.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_mahasiswa.php">
                <i class="fas fa-fw fa-user-graduate"></i>
                <span>Data Mahasiswa</span></a>
        </li>

        <!-- Menu Data Dosen -->
        <li class="nav-item">
            <a class="nav-link collapsed <?= is_active_file('data_dosen.php') || is_active_file('data_pembimbing.php') || is_active_file('data_kaprodi.php') || is_active_file('data_kaprodi.php') ? 'active' : ''; ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user"></i>
                <span>Data Dosen</span>
            </a>
            <div id="collapseTwo" class="collapse <?= is_active_file('data_dosen.php') || is_active_file('data_pembimbing.php') || is_active_file('data_kaprodi.php') ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Master Dosen:</h6>
                    <a class="collapse-item <?= is_active_file('data_dosen.php') ? 'active' : ''; ?>" href="data_dosen.php">Data Dosen</a>
                    <a class="collapse-item <?= is_active_file('data_pembimbing.php') ? 'active' : ''; ?>" href="data_pembimbing.php">Data Dosen Pembimbing</a>
                    <a class="collapse-item <?= is_active_file('data_kaprodi.php') ? 'active' : ''; ?>" href="data_kaprodi.php">Data Kaprodi</a>
                </div>
            </div>
        </li>

        <!-- Menu Data Kelompok -->
        <li class="nav-item <?= is_active_file('data_kelompok.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_kelompok.php">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Data Kelompok</span></a>
        </li>

        <!-- Menu Data Lokasi -->
        <li class="nav-item <?= is_active_file('data_lokasi.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_lokasi.php">
                <i class="fas fa-fw fa-map-marker-alt"></i>
                <span>Data Lokasi</span></a>
        </li>

        <!-- Menu Data Tahun Akademik -->
        <li class="nav-item <?= is_active_file('data_tahun-akademik.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_tahun-akademik.php">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Data Tahun Akademik</span></a>
        </li>

        <!-- Menu Data Fakultas -->
        <li class="nav-item <?= is_active_file('data_fakultas.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_fakultas.php">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>Data Fakultas</span></a>
        </li>

        <!-- Menu Data Prodi -->
        <li class="nav-item <?= is_active_file('data_prodi.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="data_prodi.php">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Data Prodi</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kelompok
        </div>

        <!-- Menu Kelompok -->
        <li class="nav-item <?= is_active_file('kelompok.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="kelompok.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelompok</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan</span>
            </a>
            <div id="collapsePages" class="collapse <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'show' : ''; ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis Laporan:</h6>
                    <a class="collapse-item <?= is_active_file('laporan_kegiatan.php') ? 'active' : ''; ?>" href="laporan_kegiatan.php">Laporan Harian Kelompok</a>
                    <a class="collapse-item <?= is_active_file('laporan_akhir.php') ? 'active' : ''; ?>" href="laporan_akhir.php">Laporan Akhir</a>
                    <a class="collapse-item <?= is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="laporan_nilai.php">Laporan Nilai</a>
                </div>
            </div>
        </li>

     <?php }elseif($_SESSION['role'] === 'Kaprodi'){?>
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Mahasiswa
        </div>

        <!-- Verifikasi Mahasiswa -->
        <li class="nav-item <?= is_active_file('data_mahasiswa.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="Verifikasi_mahasiswa.php">
                <i class="fas fa-fw fa-user-graduate"></i>
                <span>Verifikasi Mahasiswa</span></a>
        </li>

        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Laporan Nilai Mahasiswa Sesuai prodi Kaprodi -->
        <li class="nav-item <?= is_active_file('data_mahasiswa.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="laporan_nilai_mahasiswa.php">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan Nilai Mahasiswa</span></a>
        </li>

     <?php }elseif($_SESSION['role'] === 'Pembimbing'){?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kelompok
        </div>

        <!-- Menu Kelompok -->
        <li class="nav-item <?= is_active_file('kelompok.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="kelompok.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelompok</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan</span>
            </a>
            <div id="collapsePages" class="collapse <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'show' : ''; ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis Laporan:</h6>
                    <a class="collapse-item <?= is_active_file('laporan_kegiatan.php') ? 'active' : ''; ?>" href="laporan_kegiatan.php">Laporan Harian Kelompok</a>
                    <a class="collapse-item <?= is_active_file('laporan_akhir.php') ? 'active' : ''; ?>" href="laporan_akhir.php">Laporan Akhir</a>
                    <a class="collapse-item <?= is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="laporan_nilai.php">Laporan Nilai</a>
                </div>
            </div>
        </li>
     <?php }elseif($_SESSION['role'] === 'Mahasiswa'){?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Kelompok
        </div>

        <!-- Menu Kelompok -->
        <li class="nav-item <?= is_active_file('kelompok.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="kelompok.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Kelompok</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan</span>
            </a>
            <div id="collapsePages" class="collapse <?= is_active_file('laporan_kegiatan.php') || is_active_file('laporan_akhir.php') || is_active_file('laporan_nilai.php') ? 'show' : ''; ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis Laporan:</h6>
                    <a class="collapse-item <?= is_active_file('laporan_kegiatan.php') ? 'active' : ''; ?>" href="laporan_kegiatan.php">Laporan Harian Kelompok</a>
                    <a class="collapse-item <?= is_active_file('laporan_akhir.php') ? 'active' : ''; ?>" href="laporan_akhir.php">Laporan Akhir</a>
                    <a class="collapse-item <?= is_active_file('laporan_nilai.php') ? 'active' : ''; ?>" href="laporan_nilai.php">Laporan Nilai</a>
                </div>
            </div>
        </li>
     <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->