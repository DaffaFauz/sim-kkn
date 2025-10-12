<?php
require_once '../config/db.php';

// Cek Fakultas
if(isset($_POST['fakultas'])){
    $id_fakultas = intval($_POST['fakultas']);
    $stmt = $pdo->prepare("SELECT id_prodi, nama_prodi FROM prodi WHERE id_fakultas = ?");
    $stmt->execute([$id_fakultas]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

}


?>