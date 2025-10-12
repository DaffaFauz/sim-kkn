<?php
require_once '../config/db.php';
require_once '../models/Mahasiswa.php';
require_once '../includes/functions.php';

if(isset($_POST['daftar'])){
    // Mengambil Data mahasiswa dari Form
    $nim = trim($_POST['nim']);
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $fakultas = trim($_POST['fakultas']);
    $prodi = trim($_POST['prodi']);
    $kelas = trim($_POST['kelas']);
    $tahun_akademik = trim($_POST['thn_akademik']);

    // Validasi Input
    if (empty($nim) || empty($nama) || empty($alamat) || empty($fakultas) || empty($prodi) || empty($kelas) || empty($tahun_akademik)) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Semua field harus diisi!');
        exit;
    }

    // Cek NIM di tabel mahasiswa
    $cek = $pdo->prepare("SELECT nim FROM mahasiswa WHERE nim = ?");
    $cek->execute([$nim]);
    $result = $cek->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'NIM sudah terdaftar!');
    }

      // Validasi upload file
    if (!isset($_FILES['bukti_bayar']) || $_FILES['bukti_bayar']['error'] !== UPLOAD_ERR_OK) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Upload bukti pembayaran gagal!');
    }elseif($_FILES['bukti_bayar']['size'] > 5 * 1024 * 1024){
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Ukuran file terlalu besar! Maks. 5MB');
    }elseif(!in_array(mime_content_type($_FILES['bukti_bayar']['tmp_name']), ['image/png', 'image/jpeg'])){
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Format file tidak didukung! File harus dalam format PNG atau JPEG');
    }

    // Mengambil bukti bayar dari input file
    $bukti_bayar = uploadFile($_FILES['bukti_bayar'], '../assets/uploads/bukti_bayar');

    if (!$bukti_bayar) {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Upload bukti pembayaran gagal');
    }

    // Membuat Objek Mahasiswa
    $mahasiswa = new Mahasiswa($pdo);
    $result = $mahasiswa->daftar($nim, $nama, $alamat, $fakultas, $prodi, $kelas, $tahun_akademik, $bukti_bayar);

    if ($result) {
        redirectWithMsg('../auth/login.php', 'Pendaftaran berhasil! Silahkan login.');
    } else {
        redirectWithMsg('../views/mahasiswa/pendaftaran.php', 'Terjadi kesalahan, coba lagi.');
    }
    echo "Halo";
}
