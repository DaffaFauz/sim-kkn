<?php
session_start();
if(!isset($_SESSION['available_roles']) || !isset($_SESSION['id_user'])){
    header('location: ../auth/login.php?pesan=belum_login');
    exit;
}
$roles = $_SESSION['available_roles'];
$nama =$_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role || KKN MU</title>
    <link rel="stylesheet" href="../assets/css/sb-admin-2.min.css">
</head>
    <body class="bg-light">

        <div class="container py-5">
            <div class="card shadow-lg mx-auto" style="max-width: 480px;">
                <div class="card-body text-center">
                    <h4 class="mb-3">Selamat datang, <strong><?= htmlspecialchars($nama); ?></strong> 👋</h4>
                    <p class="mb-4">Silakan pilih peran yang ingin Anda gunakan:</p>

                    <?php foreach ($roles as $role): ?>
                        <form action="../controllers/RoleSelector.php" method="POST" class="mb-2">
                            <input type="hidden" name="selected_role" value="<?= htmlspecialchars($role); ?>">
                            <button type="submit" class="btn btn-primary btn-block">
                                Masuk sebagai <?= htmlspecialchars($role); ?>
                            </button>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </body>
</html>