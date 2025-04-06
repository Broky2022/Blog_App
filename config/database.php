<?php
    require 'constains.php';

    // kết nối database (địa chỉ từ constains.php)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // kiểm tra kết nối
    if (mysqli_errno($conn)) {
        die(mysqli_errno($conn));
    }

    // kiểm tra database đã tồn tại chưa, nếu chưa thì tạo mới
    $conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $conn->query("USE " . DB_NAME . ";");

    // tạo categories table
    $conn->query("DROP TABLE IF EXISTS categories;");
    $conn->query("CREATE TABLE IF NOT EXISTS categories (
        id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        title varchar(50) NOT NULL,
        description text NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // tạo posts table
    $conn->query("DROP TABLE IF EXISTS posts;");
    $conn->query("CREATE TABLE IF NOT EXISTS posts (
        id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        body text NOT NULL,
        thumbnail varchar(255) NOT NULL,
        date_time timestamp NOT NULL DEFAULT current_timestamp(),
        category_id int(11) UNSIGNED DEFAULT NULL,
        author_id int(11) UNSIGNED NOT NULL,
        is_featured tinyint(1) NOT NULL,
        PRIMARY KEY (id),
        KEY FK_blog_category (category_id),
        KEY FK_blog_author (author_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // tạo users table
    $conn->query("DROP TABLE IF EXISTS users;");
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        firstname varchar(50) NOT NULL,
        lastname varchar(50) NOT NULL,
        username varchar(50) NOT NULL,
        email varchar(100) NOT NULL,
        password varchar(255) NOT NULL,
        avatar varchar(255) NOT NULL,
        is_admin tinyint(1) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // thêm khóa
    $conn->query("ALTER TABLE posts
    ADD CONSTRAINT FK_blog_author FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE CASCADE,
    ADD CONSTRAINT FK_blog_category FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL;");
?>