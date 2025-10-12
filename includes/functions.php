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
