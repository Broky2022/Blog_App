<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var(trim($_POST['body']), FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $previous_thumbnail = $_POST['previous_thumbnail'];
    $thumbnail = $_FILES['thumbnail'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($title) || empty($body) || empty($category_id)) {
        $_SESSION['edit-post-error'] = "Vui lòng điền đầy đủ thông tin!";
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        exit;
    }

    // Xử lý ảnh thumbnail nếu có upload mới
    if (!empty($thumbnail['name'])) {
        $time = time(); // Tạo tên file duy nhất
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Kiểm tra định dạng file
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

        if (!in_array($extension, $allowed_files)) {
            $_SESSION['edit-post-error'] = "Vui lòng chọn ảnh có định dạng png, jpg hoặc jpeg!";
            header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
            exit;
        }

        // Kiểm tra kích thước file
        if ($thumbnail['size'] > 2_000_000) { // 2MB
            $_SESSION['edit-post-error'] = "Kích thước ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 2MB!";
            header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
            exit;
        }

        // Xóa ảnh cũ
        if ($previous_thumbnail) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }
        }

        // Upload ảnh mới
        move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
    } else {
        $thumbnail_name = $previous_thumbnail; // Giữ nguyên ảnh cũ nếu không upload mới
    }

    // Nếu bài viết được đánh dấu nổi bật, đặt các bài viết khác không nổi bật
    if ($is_featured == 1) {
        $reset_featured_query = "UPDATE posts SET is_featured = 0";
        mysqli_query($conn, $reset_featured_query);
    }

    // Cập nhật bài viết trong cơ sở dữ liệu
    $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_name', category_id = $category_id, is_featured = $is_featured WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['edit-post-success'] = "Cập nhật bài viết thành công!";
        header('location: ' . ROOT_URL . 'admin/index.php');
        exit;
    } else {
        $_SESSION['edit-post-error'] = "Có lỗi xảy ra khi cập nhật bài viết!";
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        exit;
    }
} else {
    header('location: ' . ROOT_URL . 'admin/index.php');
    exit;
}