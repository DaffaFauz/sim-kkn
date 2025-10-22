<?php
require_once '../config/db.php';
require_once '../models/Prodi.php';
require_once '../includes/functions.php';
checkLogin();
checkRole(['Admin']);

$prodiModel = new Prodi($pdo);

// Tambah Prodi
if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $fakultas_id = $_POST['id_fakultas'];
    if(empty($kode_prodi) || empty($nama_prodi) || empty($fakultas_id)){
        redirectWithMsg('../views/admin/data_prodi.php', 'Semua field harus diisi.', 'danger');
    }

    $result = $prodiModel->tambah($kode_prodi, $nama_prodi, $fakultas_id);

    if($result){
        redirectWithMsg('../views/admin/data_prodi.php', 'Prodi berhasil ditambahkan.', 'success');
    } else {
        redirectWithMsg('../views/admin/data_prodi.php', 'Gagal menambahkan prodi.', 'danger');
    }
    exit;
}

// Ubah Prodi
if(isset($_POST['ubah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_prodi = $_POST['id_prodi'];
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $id_fakultas = $_POST['id_fakultas'];

    $result = $prodiModel->ubah($id_prodi, $kode_prodi, $nama_prodi, $id_fakultas);

    if($result){
        redirectWithMsg('../views/admin/data_prodi.php', 'Prodi berhasil diubah.', 'success');
    } else {
        redirectWithMsg('../views/admin/data_prodi.php', 'Gagal mengubah prodi.', 'danger');
    }
    exit;
}

// hapus Prodi
if(isset($_POST['hapus']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_prodi = $_POST['id_prodi'];
    if(empty($id_prodi)){
        redirectWithMsg('../views/admin/data_prodi.php', 'ID Prodi tidak ditemukan.', 'danger');
    }
    
    $result = $prodiModel->hapus($id_prodi);
    if($result){
        redirectWithMsg('../views/admin/data_prodi.php', 'Prodi berhasil dihapus.', 'success');
    } else {
        redirectWithMsg('../views/admin/data_prodi.php', 'Gagal menghapus prodi.', 'danger');
    }
    exit;
}

?>