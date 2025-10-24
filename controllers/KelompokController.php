<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
checkLogin();
checkRole(['Admin']);

require_once '../models/Fakultas.php';
require_once '../models/Kelompok.php';
require_once '../models/TahunAkademik.php';
require_once '../models/Prodi.php';
require_once '../models/Lokasi.php';


$fakultas = new Fakultas($pdo);
$kelompok = new Kelompok($pdo);
$tahun_akademik = new TahunAkademik($pdo);
$prodi = new Prodi($pdo);
$lokasi = new Lokasi($pdo);

$fakultas->getAll();
$kelompok->getAll();
$tahun_akademik->getAll();
$prodi->getAll();
$lokasi->getAll();

// Tambah Kelompok
if(isset($_POST['tambah']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama_kelompok = $_POST['nama_kelompok'];
    $id_lokasi = $_POST['id_lokasi'];
    $id_tahun = $_POST['id_tahun'];

    if(empty($nama_kelompok) || empty($id_lokasi) || empty($id_tahun)){
        redirectWithMsg("../views/admin/data_kelompok.php", "Semua field harus diisi.", "danger");
        exit();
    }
    $result = $kelompok->tambah($nama_kelompok, $id_lokasi, $id_tahun);
    if($result){
        redirectWithMsg("../views/admin/data_kelompok.php", "Data kelompok berhasil ditambahkan.", "success");
    }else{
        redirectWithMsg("../views/admin/data_kelompok.php", "Terjadi kesalahan saat menambahkan kelompok.", "danger");
    }
    exit();

}

// Ubah Kelompok
if(isset($_POST['ubah'])){
    $id_kelompok = $_POST['id_kelompok'];
    $nama_kelompok = $_POST['nama_kelompok'];

    try{
        $kelompok->ubah($id_kelompok, $nama_kelompok);
        header("Location: ../views/kelompok/index.php?status=success&message=Data kelompok berhasil diubah");
    }catch(Exception $e){
        header("Location: ../views/kelompok/index.php?status=error&message=" . urlencode($e->getMessage()));
    }
}
?>