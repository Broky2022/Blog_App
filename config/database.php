<?php
    require 'constains.php';

    // kết nối database (địa chỉ từ constains.php)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // kiểm tra kết nối
    if (mysqli_errno($conn)) {
        die(mysqli_errno($conn));
    }
?>