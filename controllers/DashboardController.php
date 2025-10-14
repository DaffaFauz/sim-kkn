<?php
session_start();
require_once '../config/db.php';
require_once '../models/Dashboard.php';

if(!isset($_SESSION['role']) || !isset($_SESSION['id_user'])){
    header('location: ../auth/login.php?pesan=belum_login');
    exit;
}

$dashboardModel = new Dashboard($pdo);
$role = $_SESSION['role'];

switch($role){
    case 'Admin':
        $data = $dashboardModel->getAdminData();
        include '../views/admin/dashboard.php';
        break;
    case 'Kaprodi':
        $data = $dashboardModel->getKaprodiData($_SESSION['id_user']);
        include '../views/kaprodi/dashboard.php';
        break;
    case 'Pembimbing':
        $data = $dashboardModel->getPembimbingData($_SESSION['id_user']);
        include '../views/pembimbing/dashboard.php';
        break;
    case 'Mahasiswa':
        $data = $dashboardModel->getMahasiswaData($_SESSION['id_user']);
        include '../views/mahasiswa/dashboard.php';
        break;
    default:
        header('location: ../auth/login.php?pesan=roleerror');
        exit;
}

?>