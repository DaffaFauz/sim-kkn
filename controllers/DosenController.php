<?php
require_once '../config/db.php';
require_once '../models/Dosen.php';
require_once '../includes/functions.php';

$dosen = new Dosen($pdo);

$dosenModel = new Dosen($pdo);

if (isset($_POST['aksi'])) {
    $aksi = $_POST['aksi'];

    switch ($aksi) {
        case 'tambah':
            $nama = $_POST['nama_dosen'];
            $jabatan = $_POST['jabatan'];
            $dosenModel->tambahDosen($nama, $jabatan);
            header('location: ../views/admin/dosen.php?pesan=sukses_tambah');
            break;

        case 'ubah_jabatan':
            $id_dosen = $_POST['id_dosen'];
            $jabatan_baru = $_POST['jabatan_baru'];
            $dosenModel->ubahJabatan($id_dosen, $jabatan_baru);
            header('location: ../views/admin/dosen.php?pesan=sukses_ubah');
            break;

        default:
            header('location: ../views/admin/dosen.php?pesan=aksi_tidak_dikenal');
            break;
    }
}

?>