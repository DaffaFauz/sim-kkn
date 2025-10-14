<?php
function uploadFile($file, $path)
{
    $file_name = time() . '-' . basename($file['name']);
    $target_file = $path . '/' . $file_name;
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $file_name;
    }
    return false;
}

function redirectWithMsg($url, $msg)
{
    session_start();
    $_SESSION['msg'] = $msg;
    header("location: $url");
    exit;
}

function checkLogin(){
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: ../../auth/login.php?pesan=belum_login');
        exit;
    }

    // Mendapatkan path halaman yang sedang diakses
    $currentPath = str_replace('\\','/', dirname($_SERVER['PHP_SELF']));

    // Ambil folder utama setelah views
    $pathParts = explode('/', $currentPath);
    $folderName = '';
    if(($key = array_search('views', $pathParts)) !== false && isset($pathParts[$key + 1])){
        $folderName = strtolower($pathParts[$key + 1]);
    }

    // Map folder ke role
    $roleMap = [
        'admin' => 'Admin',
        'kaprodi' => 'Kaprodi',
        'pembimbing' => 'Pembimbing',
        'mahasiswa' => 'Mahasiswa'
    ];

    // Cek folder yang memiliki role
    if(array_key_exists($folderName, $roleMap)){
        $expectedRole = $roleMap[$folderName];
        $userRole = strtolower($_SESSION['role']);
        $expectedRoleLower = strtolower($expectedRole);

        if($userRole !== $expectedRoleLower){
            header('location: ../../auth/login.php?pesan=roleerror');
            exit;
        }
    }
        

}

// Jika halaman ini membutuhkan role tertentu, kita cek sesuai kebutuhan
function checkRole($allowed_roles = []) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        header('location: ../../auth/login.php?pesan=roleerror');
        exit;
    }
}