<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Lấy thông tin bài viết để xóa ảnh thumbnail
    $query = "SELECT thumbnail FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);

    if ($post) {
        $thumbnail_path = '../images/' . $post['thumbnail'];

        // Xóa ảnh thumbnail nếu tồn tại
        if ($post['thumbnail'] && file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }

        // Xóa bài viết khỏi cơ sở dữ liệu
        $delete_query = "DELETE FROM posts WHERE id = $id LIMIT 1";
        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            $_SESSION['delete-post-success'] = "Xóa bài viết thành công!";
        } else {
            $_SESSION['delete-post-error'] = "Có lỗi xảy ra khi xóa bài viết!";
        }
    } else {
        $_SESSION['delete-post-error'] = "Bài viết không tồn tại!";
    }

    header('location: ' . ROOT_URL . 'admin/index.php');
    exit;
} else {
    header('location: ' . ROOT_URL . 'admin/index.php');
    exit;
}