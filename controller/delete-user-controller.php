<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    // lấy dữ liệu người dùng dựa trên ID
    $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Lấy thông tin avatar của người dùng
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        // xóa ảnh
        if ($avatar_path){
            unlink($avatar_path);
        }
    }

    // xóa người dùng khỏi database
    $delete_user_query = "DELETE FROM users WHERE id = $user_id LIMIT 1";
    $delete_user_result = mysqli_query($conn, $delete_user_query);

    if (mysqli_errno($conn)) {
        $_SESSION['delete-user-error'] = "Xóa người dùng '{$user['lastname']} {$user['firstname']}' thất bại";
    } else {
        $_SESSION['delete-user-success'] = "Xóa người dùng '{$user['lastname']} {$user['firstname']}' thành công";
    }

    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    exit;

} else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    exit;
}
