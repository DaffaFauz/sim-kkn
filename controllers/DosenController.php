<?php
require_once '../config/db.php';
require_once '../models/Dosen.php';
require_once '../includes/functions.php';

if(isset($_POST['tambah'])){
    $nidn = trim($_POST['nidn']);
    $nama_dosen = trim($_POST['nama_dosen']);
    $id_prodi = trim($_POST['id_prodi']);
    $jabatan = trim($_POST['jabatan']);
    if(empty($nidn) || empty($nama_dosen) || empty($id_prodi) || empty($jabatan)){
        redirectWithMsg('../views/admin/data_dosen.php', 'Semua field harus diisi!', 'danger');
        exit;
    }
    $dosen = new Dosen($pdo);
    $result = $dosen->tambah($nidn, $nama_dosen, $id_prodi, $jabatan);
    if($result){
        redirectWithMsg('../views/admin/data_dosen.php', 'Data dosen berhasil ditambahkan!', 'success');
        exit;
    }else{
        redirectWithMsg('../views/admin/data_dosen.php', 'Terjadi kesalahan, coba lagi!', 'danger');
        exit;
    }
}
?>