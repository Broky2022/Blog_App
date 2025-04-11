<?php
    require '../config/constains.php';

    // Xóa session người dùng và trở về home page
    session_destroy();
    // Xóa cookie
    // if (isset($_COOKIE['user_id'])) {
    //     setcookie('user_id', '', time() - 3600, '/');
    // }
    header('location: ' . ROOT_URL);
    exit;
?>