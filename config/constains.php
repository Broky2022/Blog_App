<?php
    session_start();
    define('ROOT_URL', 'http://localhost/Blog_App/'); // đường dẫn đến thư mục gốc của ứng dụng tại htdocs
    define('DB_HOST', 'localhost:3306');
    define('DB_USER', 'root'); // user sửa dụng để kết nối đến database
    define('DB_PASS', 'Aa123456'); // password sửa dụng để kết nối đến database
    define('DB_NAME', 'blog'); // tên database

    // Kết nối database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }
?>