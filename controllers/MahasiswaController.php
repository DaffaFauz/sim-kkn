<?php
require_once '../config/db.php';
require_once '../models/Mahasiswa.php';
require_once '../includes/functions.php';
require_once '../models/Prodi.php';

$prodi = new Prodi($pdo);

// Cek Fakultas
if(isset($_POST['fakultas'])){
    $id_fakultas = trim($_POST['fakultas']);
    $result = $prodi->DaftarProdiByFakultas($id_fakultas);
    if($result !== false){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        // Mengembalikan array kosong jika terjadi kesalahan atau tidak ada data
        echo json_encode([]);
    }   
}

if(isset($_POST['daftar'])){
    // Mengambil Data mahasiswa dari Form
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $prodi = trim($_POST['prodi']);
    $kelas = trim($_POST['kelas']);

    // Validasi Input
    if (empty($nim) || empty($nama) || empty($alamat) || empty($jenis_kelamin) || empty($prodi) || empty($kelas)) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Semua field harus diisi!');
        exit;
    }

    // Cek NIM di tabel mahasiswa
    $cek = $pdo->prepare("SELECT nim FROM mahasiswa WHERE nim = ?");
    $cek->execute([$nim]);
    $result = $cek->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'NIM sudah terdaftar!', 'warning');
    }

    // Membuat Objek Mahasiswa
    $mahasiswa = new Mahasiswa($pdo);
    $data = [
        'nim' => $nim,
        'nama' => $nama,
        'alamat' => $alamat,
        'jenis_kelamin' => $jenis_kelamin,
        'id_prodi' => $prodi,
        'kelas' => $kelas
    ];
    $result = $mahasiswa->create($data);

    if ($result) {
        redirectWithMsg('../auth/login.php', 'Pendaftaran berhasil! Silahkan login.', 'success');
    } else {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Terjadi kesalahan, coba lagi.', 'danger');
        exit;
    }
}



if(isset($_POST['hapus']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_mahasiswa = trim($_POST['id_mahasiswa']);
    $mahasiswa = new Mahasiswa($pdo);
    $result = $mahasiswa->hapus($id_mahasiswa);
    if($result){
        redirectWithMsg('../views/admin/data_mahasiswa.php', 'Data mahasiswa berhasil dihapus!', 'success');
        exit;
    }else{
        redirectWithMsg('../views/admin/data_mahasiswa.php', 'Terjadi kesalahan, coba lagi!', 'danger');
        exit;
    }
}
