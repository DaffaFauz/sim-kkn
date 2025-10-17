<?php
include_once '../config/db.php';
include_once '../models/Lokasi.php';
require_once '../includes/functions.php';
checkLogin();
checkRole(['Admin']);

if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama_desa = trim($_POST['nama_desa']);
    $nama_kecamatan = trim($_POST['nama_kecamatan']);
    $nama_kabupaten = trim($_POST['nama_kabupaten']);
    if(empty($nama_desa) || empty($nama_kecamatan) || empty($nama_kabupaten)){
        redirectWithMsg('../views/admin/data_lokasi.php', 'Semua field harus diisi!');
        exit;
    }
    $lokasi = new Lokasi($pdo);
    $result = $lokasi->tambah($nama_desa, $nama_kecamatan, $nama_kabupaten);
    if($result){
        redirectWithMsg('../views/admin/data_lokasi.php', 'Data lokasi berhasil ditambahkan!', 'success');
        exit;
    }else{
        redirectWithMsg('../views/admin/data_lokasi.php', 'Terjadi kesalahan, coba lagi!', 'danger');
        exit;
        }
}

if(isset($_POST['edit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_lokasi = trim($_POST['id_lokasi']);
    $nama_desa = trim($_POST['nama_desa']);
    $nama_kecamatan = trim($_POST['nama_kecamatan']);
    $nama_kabupaten = trim($_POST['nama_kabupaten']);
    if(empty($nama_desa) || empty($nama_kecamatan) || empty($nama_kabupaten)){
        redirectWithMsg('../views/admin/data_lokasi.php', 'Semua field harus diisi!');
        exit;
    }
    $lokasi = new Lokasi($pdo);
    $result = $lokasi->edit($id_lokasi, $nama_desa, $nama_kecamatan, $nama_kabupaten);
    if($result){
        redirectWithMsg('../views/admin/data_lokasi.php', 'Data lokasi berhasil diubah!', 'success');
        exit;
    }else{
        redirectWithMsg('../views/admin/data_lokasi.php', 'Terjadi kesalahan, coba lagi!', 'danger');
        exit;
    }
}

if(isset($_POST['hapus']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_lokasi = trim($_POST['id_lokasi']);
    $lokasi = new Lokasi($pdo);
    $result = $lokasi->hapus($id_lokasi);
    if($result){
        redirectWithMsg('../views/admin/data_lokasi.php', 'Data lokasi berhasil dihapus!', 'success');
        exit;
    }else{
        redirectWithMsg('../views/admin/data_lokasi.php', 'Terjadi kesalahan, coba lagi!', 'danger');
        exit;
    }
}
?>