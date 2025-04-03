<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // lấy thông tin từ form đăng nhập
    $username_email = filter_var($_POST['username/email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // kiểm tra xem các trường có rỗng hay không
    if (empty($username_email) || empty($password)) {
        $_SESSION['signin'] = "Vui lòng điền đầy đủ thông tin!";
        header('location: ' . ROOT_URL . 'signin.php');
        exit;
    } else {
        // kiểm tra username or email có hợp lệ không
        $user_check_query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
        $user_check_result = mysqli_query($conn, $user_check_query);

        if (mysqli_num_rows($user_check_result) > 0) {
            // lấy thông tin người dùng
            $user_profile = mysqli_fetch_assoc($user_check_result);
            $db_password = $user_profile['password'];
            // kiểm tra mật khẩu có đúng không
            if (password_verify($password, $db_password)) {
                // thiết lập session cho người dùng
                $_SESSION['user-id'] = $user_profile['id'];
                // thiết lập session nếu user là admin
                if ($user_profile['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // chuyển hướng đến trang admin
                // nếu người dùng là admin thì chuyển hướng đến trang admin
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "Mật khẩu không đúng!";
            }
        } else {
            $_SESSION['signin'] = "Tên đăng nhập hoặc email không tồn tại!";
        }
    }

    // nếu có lỗi thì lưu lại dữ liệu để hiển thị lại cho người dùng
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        exit;
    }
} else {
    header('location: ' . ROOT_URL . 'signin.php');
    exit;
} 