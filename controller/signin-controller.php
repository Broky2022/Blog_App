<?php
require '../config/database.php';
require '../vendor/autoload.php';
require '../config/mail.php';
require '../config/session-manager.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Khởi tạo session với thời hạn 30 phút
SessionManager::start(1800);

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
                // Lưu thông tin người dùng vào session
                $_SESSION['user-id'] = $user_profile['id'];
                $_SESSION['user_email'] = $user_profile['email'];
                
                // thiết lập session nếu user là admin
                if ($user_profile['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // Thiết lập thời hạn session dài hơn (2 giờ) cho người dùng đã đăng nhập
                SessionManager::setTimeout(7200); // 2 giờ

                // Kiểm tra xem người dùng có bật 2FA không
                if ($user_profile['two_factor_enabled'] == 1) {
                    // Chuyển hướng đến trang xác thực 2 bước
                    header('location: ' . ROOT_URL . 'two-factor.php');
                    exit;
                }

                // Nếu không bật 2FA, chuyển hướng đến trang admin hoặc trang chủ
                if (isset($_SESSION['user_is_admin'])) {
                    header('location: ' . ROOT_URL . 'admin/');
                } else {
                    header('location: ' . ROOT_URL);
                }
                exit;
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