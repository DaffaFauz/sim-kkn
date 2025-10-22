<?php
require_once '../config/db.php';
require_once '../models/Fakultas.php';
require_once '../includes/functions.php';
checkLogin();
checkRole(['Admin']);

$fakultas = new Fakultas($pdo);

if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $kode_fakultas = trim($_POST['kode_fakultas']);
    $nama_fakultas = trim($_POST['nama_fakultas']);

    if(empty($kode_fakultas) || empty($nama_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Kode Fakultas dan Nama Fakultas wajib diisi.", "danger");
        exit();
    }
    if($fakultas->tambah($nama_fakultas, $kode_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Fakultas berhasil ditambahkan.", "success");
    }else{
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Terjadi kesalahan saat menambahkan fakultas.", "danger");
    }
    exit();
}

if(isset($_POST['ubah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_fakultas = trim($_POST['id_fakultas']);
    $kode_fakultas = trim($_POST['kode_fakultas']);
    $nama_fakultas = trim($_POST['nama_fakultas']);

    if(empty($kode_fakultas) || empty($nama_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Kode Fakultas dan Nama Fakultas wajib diisi.", "danger");
        exit();
    }
    if($fakultas->ubah($id_fakultas, $kode_fakultas, $nama_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Fakultas berhasil diubah.", "success");
    }else{
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Terjadi kesalahan saat mengubah fakultas.", "danger");
    }
    exit();
}

if(isset($_POST['hapus']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_fakultas = trim($_POST['id_fakultas']);
    if(empty($id_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "ID Fakultas tidak ditemukan.", "danger");
        exit();
    }
    
    if($fakultas->hapus($id_fakultas)){
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Fakultas berhasil dihapus.", "success");
    }else{
        redirectWithMsg("Location: ../views/admin/data_fakultas.php", "Terjadi kesalahan saat menghapus fakultas.", "danger");
    }
    exit();
}