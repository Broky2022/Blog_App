<?php
// signup logic
require '../config/database.php';

// lấy thông tin từ form sau khi nhấn nút đăng ký
if (isset($_POST['submit'])) {
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($title)) {
        $_SESSION['add-category-error'] = "Vui lòng nhập tiêu đề!";
    } elseif (empty($description)) {
        $_SESSION['add-category-error'] = "Vui lòng nhập mô tả!";
    } else {
        // kiểm tra tiêu đề danh mục có hợp lệ không
        $category_check_query = "SELECT * FROM categories WHERE title = '$title'";
        $category_check_result = mysqli_query($conn, $category_check_query);
        if (mysqli_num_rows($category_check_result) > 0) {
            $_SESSION['add-category-error'] = "Category đã tồn tại!";
        } 
    }

    // nếu không có lỗi thì thêm danh mục vào database
    if (isset($_SESSION['add-category-error'])) {
        // nếu có lỗi thì chuyển hướng về trang thêm danh mục
        $_SESSION['add-category-data'] = $_POST; // lưu lại thông tin đã nhập
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        exit;
    } else {
        // thêm danh mục vào database
        $insert_category_query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $insert_category_result = mysqli_query($conn, $insert_category_query);

        if (!mysqli_errno($conn)) {
            $_SESSION['add-category-success'] = "Category $title đã được thêm thành công!";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            exit;
        } else {
            $_SESSION['add-category-error'] = "Có lỗi xảy ra trong quá trình thêm danh mục!";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            exit;
        }
    }
}
?>
