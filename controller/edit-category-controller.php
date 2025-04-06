<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Lấy dữ liệu data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_SPECIAL_CHARS);

    // Kiểm tra
    if (empty($title) || empty($description)) {
        $_SESSION['edit-category-error'] = "Vui lòng điền đầy đủ thông tin!";
        header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
        exit;
    }

    // Update category in the database
    $query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['edit-category-success'] = "Cập nhật thông tin category $title thành công!";
        header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        exit;
    } else {
        $_SESSION['edit-category-error'] = "Có lỗi xảy ra khi cập nhật thông tin người dùng!";
        header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
        exit;
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    exit;
}
?>