<?php
// signup logic
require '../config/database.php';

// lấy thông tin từ form sau khi nhấn nút submit
if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var(trim($_POST['body']), FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var(trim($_POST['category']), FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var(trim($_POST['is_featured']), FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // cài is_featured mặc định là 0
    $is_featured = $is_featured == 1 ?: 0;

    // kiểm tra dữ liệu đầu vào
    if (empty($title)) {
        $_SESSION['add-post-error'] = "Vui lòng nhập tiêu đề!";
    } elseif (empty($category_id)) {
        $_SESSION['add-post-error'] = "Vui lòng chọn category!";
    } elseif (empty($body)) {
        $_SESSION['add-post-error'] = "Vui lòng nhập nội dung bài viết!";
    } elseif (empty($thumbnail['name'])) {
        $_SESSION['add-post-error'] = "Vui lòng chọn ảnh thumbnail!";
    } else {
        // ảnh thumbnail
        $time = time(); // lấy thời gian hiện tại để tạo tên ảnh thumbnail duy nhất
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;
        $allowed_files = ['png', 'jpg', 'jpeg']; // định dạng ảnh cho phép
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);

        if (!in_array($extension, $allowed_files)) {
            $_SESSION['add-post-error'] = "Vui lòng chọn ảnh có định dạng png, jpg hoặc jpeg!";
        } elseif ($thumbnail['size'] > 2_000_000) { // 2MB
            $_SESSION['add-post-error'] = "Kích thước ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 2MB!";
        } else {
            // upload ảnh thumbnail
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
        }
    }

    // nếu không có lỗi thì thêm danh mục vào database
    if (isset($_SESSION['add-post-error'])) {
        // nếu có lỗi thì chuyển hướng về trang thêm danh mục
        $_SESSION['add-post-data'] = $_POST; // lưu lại thông tin đã nhập
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        exit;
    } else {
        // set is_featured tất cả post khác là 0 nếu post này là 1
        if ($is_featured == 1) {
            $query_all_featured = "UPDATE posts SET is_featured = 0";
            $result_all_featured = mysqli_query($conn, $query_all_featured);
        }

        // thêm bài viết vào database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', '$is_featured')";
        $result = mysqli_query($conn, $query);

        // Improve error handling for database insertion
        if (!mysqli_errno($conn)) {
            $_SESSION['add-post-success'] = "Thêm bài viết thành công!";
            header('location: ' . ROOT_URL . 'admin/index.php');
            exit;
        } else {
            $_SESSION['add-post-error'] = "Có lỗi xảy ra khi thêm bài viết: " . mysqli_error($conn);
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            exit;
        }
    }
}

header('location: ' . ROOT_URL . 'admin/index.php');
exit;