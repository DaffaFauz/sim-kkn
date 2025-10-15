<?php
session_start();
require_once '../config/db.php';
require_once '../models/User.php';

$userModel = new User($pdo);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Mendapatkan data dari form input login
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if(empty($username) || empty($password)){
        header('location: ../auth/login.php?pesan=empty');
        exit;
    }

    // Login

    $user = $userModel->login($username, $password);

    // Cek matching data user
    if($user){
        // Buat & Simpan Session
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['status'] = $user['status'];

        // Ambil data dosen (jika user dosen)
        $stmt = $pdo->prepare("SELECT * FROM dosen WHERE id_user = ?");
        $stmt->execute([$user['id_user']]);
        $dataDosen = $stmt->fetch(PDO::FETCH_ASSOC);

        // --- Tentukan role yang tersedia ---
        $available_roles = [];

        // Menyimpan role dari table user
        $available_roles[] = $user['role'];

        // Cek data jabatan data dosen
        if($dataDosen && !empty($dataDosen)){
            // Cegah duplikasi
            if(!in_array($dataDosen['jabatan'], $available_roles)){
                $available_roles[] = $dataDosen['jabatan'];
            }
        }

        $_SESSION['nama'] = $dataDosen['nama_dosen'];
        


        // Memeriksa multi role
        if(count($available_roles) > 1 && in_array('Dosen', $available_roles)){
            if($available_roles[0] === 'Admin'){
                $_SESSION['available_roles'] = $available_roles[0];
                header('location: ../views/admin/dashboard.php');
            }elseif($available_roles[0] === 'Kaprodi'){
                header('location: ../views/kaprodi/dashboard.php');
            }elseif($available_roles[0] === 'Pembimbing'){
                header('location: ../views/pembimbing/dashboard.php');
            }
            exit;
        }elseif(count($available_roles) > 1 && !in_array('Dosen', $available_roles)){
            $_SESSION['available_roles'] = $available_roles;
            header('location: ../views/endpoint.php');
            exit;
        }else{
            // Jika role hanya 1
            $finalRole = $available_roles[0];

        // Redirect masing-masing role
        if($finalRole === 'Admin'){
            $_SESSION['available_roles'] = $available_roles[0];
            header('location: ../views/admin/dashboard.php');
        }elseif($finalRole === 'Kaprodi'){
            header('location: ../views/kaprodi/dashboard.php');
        }elseif($finalRole === 'Pembimbing'){
            header('location: ../views/pembimbing/dashboard.php');
        }elseif($finalRole === 'Mahasiswa'){
            $getNamaFromMhs = $pdo->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_user = ?");
            $getNamaFromMhs->execute([$user['id_user']]);
            $nama = $getNamaFromMhs->fetch(PDO::FETCH_ASSOC);
            $_SESSION['nama'] = $nama['nama_mahasiswa'];
            header('location: ../views/mahasiswa/dashboard.php');
        }else{
            header('location: ../auth/login.php?pesan=roleerror');
        }
        exit;
        }
     
    }else{
        header('location: ../auth/login.php?pesan=gagal');
        exit;
    }
}

// --- Jalur jika datang dari RoleSelector.php ---
if (isset($_GET['selected_role']) && isset($_SESSION['id_user'])) {
    $finalRole = $_GET['selected_role'];
    $_SESSION['role'] = $finalRole;

    $id_user = $_SESSION['id_user'];

    // Redirect sesuai role
    if ($finalRole === 'Admin') {
        header('location: ../views/admin/dashboard.php');
    } elseif ($finalRole === 'Kaprodi') {
        header('location: ../views/kaprodi/dashboard.php');
    } elseif ($finalRole === 'Pembimbing') {
        header('location: ../views/pembimbing/dashboard.php');
    } elseif ($finalRole === 'Mahasiswa') {
        $getNamaFromMhs = $pdo->prepare("SELECT nama_mahasiswa FROM mahasiswa WHERE id_user = ?");
        $getNamaFromMhs->execute([$id_user]);
        $nama = $getNamaFromMhs->fetch(PDO::FETCH_ASSOC);
        $_SESSION['nama'] = $nama['nama_mahasiswa'];
        header('location: ../views/mahasiswa/dashboard.php');
    } else {
        header('location: ../auth/login.php?pesan=roleerror');
    }
    exit;
}

?>