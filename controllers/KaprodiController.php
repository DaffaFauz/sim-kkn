<?php
include_once '../config/db.php';

// Update Status Mahasiswa
if($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['id_mahasiswa'])){
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $status = $_POST['status'];
    $catatan_tolak = $_POST['catatan_tolak'];

    if(empty($id_mahasiswa) || empty($status) || empty($catatan_tolak)){
        header('location: ../views/kaprodi/dashboard.php');
        exit;
    }

    $stmt = $pdo->prepare("UPDATE mahasiswa SET status = ?, catatan = ? WHERE id_mahasiswa = ?");
    $updateVerifikasi = $stmt->execute([$status, $catatan_tolak, $id_mahasiswa]);

    if($updateVerifikasi){
        header('location: ../views/kaprodi/dashboard.php');
        exit;
    }else{
        header('location: ../views/kaprodi/dashboard.php?pesan=gagal');
        exit;
    }
    exit;
}



?>