<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../models/TahunAkademik.php';
checkLogin();
checkRole(['Admin']);

$tahun_akademik = new TahunAkademik($pdo);

// Tambah Tahun Akademik
if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $tahun = trim($_POST['tahun_akademik']);
    if(empty($tahun)){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Kolom harus diisi!', 'danger');
        exit;
    }else{        
        $result = $tahun_akademik->tambah($tahun);
        if($result){
            redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Data tahun akademik berhasil ditambahkan!', 'success');
            exit;
        }else{
            redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Terjadi kesalahan, coba lagi!', 'danger');
            exit;
        }
    }
}

// Ubah Status Tahun Akademik
if(isset($_POST['ubah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = trim($_POST['id']);
    if(empty($id)){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'ID tidak ditemukan!', 'danger');
    }

    $result = $tahun_akademik->ubah($id);
    if($result){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Status tahun akademik berhasil diubah!', 'success');
    } else {
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Gagal mengubah status, coba lagi!', 'danger');
    }
    exit;
 }

if(isset($_POST['hapus']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = trim($_POST['id']);
    if(empty($id)){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'ID tidak ditemukan!', 'danger');
        exit;
    }

    $result = $tahun_akademik->hapus($id);
    if($result === true){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Data tahun akademik berhasil dihapus!', 'success');
    }elseif($result === false){
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Gagal menghapus! Tahun akademik ini masih digunakan.', 'danger');
    }else{
        // Ini tidkak akan pernah terjadi, tapi untuk berjaga-jaga, Tidak dapat menghapus data jika tahun sudah terisi kelompok dan mahasiswa
        redirectWithMsg('../views/admin/data_tahun-akademik.php', 'Terjadi kesalahan saat menghapus data!', 'danger');
    }
    exit;
}
