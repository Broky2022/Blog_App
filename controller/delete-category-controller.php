<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);

    // xóa khỏi database
    $delete_category_query = "DELETE FROM categories WHERE id = $id LIMIT 1";
    $delete_category_result = mysqli_query($conn, $delete_category_query);

    if (mysqli_errno($conn)) {
        $_SESSION['delete-category-error'] = "Xóa thẻ {$category['title']} thất bại";
    } else {
        $_SESSION['delete-category-success'] = "Xóa thẻ {$category['title']} thành công";
    }

    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    exit;

} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    exit;
}
