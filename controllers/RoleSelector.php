<?php
session_start();
if(!isset($_SESSION['available_roles']) || !isset($_POST['selected_role']) ){
    header('location: ../auth/login.php?pesan=belum_login');
    exit;
}

$selected_role = $_POST['selected_role'];

if(!in_array($selected_role, $_SESSION['available_roles'])){
    header('location: ../auth/login.php?pesan=roleerror');
    exit;
}

// Simpan Role yang dipilih
$_SESSION['role'] = $selected_role;

    // Hapus double session
unset($_SESSION['available_roles']);

header('location: AuthController.php?selected_role=' . urlencode($selected_role));
exit;
?>