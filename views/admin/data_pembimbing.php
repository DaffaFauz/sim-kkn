<?php
require_once '../../config/db.php';
include_once '../../includes/functions.php';
checkLogin();
checkRole(['Admin']);
$pageTitle = 'Data Pembimbing';
?>

<!-- Head -->
<?php include '../layout/head.php';?>

<!-- Sidebar -->
<?php include '../layout/sidebar.php'; ?>

<!-- Topbar -->
<?php include '../layout/topbar.php'?>