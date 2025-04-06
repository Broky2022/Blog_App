<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Lấy dữ liệu data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_SPECIAL_CHARS);
    $userrole = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Kiểm tra
    if (empty($firstname) || empty($lastname)) {
        $_SESSION['edit-user-error'] = "Vui lòng điền đầy đủ thông tin!";
        header('location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $id);
        exit;
    }

    // Update user in the database
    $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $userrole WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['edit-user-success'] = "Cập nhật thông tin người dùng $lastname $firstname thành công!";
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        exit;
    } else {
        $_SESSION['edit-user-error'] = "Có lỗi xảy ra khi cập nhật thông tin người dùng!";
        header('location: ' . ROOT_URL . 'admin/edit-user.php?id=' . $id);
        exit;
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    exit;
}
?>