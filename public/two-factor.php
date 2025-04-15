<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/mail.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/session-manager.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Khởi tạo session với thời hạn 30 phút
SessionManager::start(1800);

// Thiết lập múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: public/signin.php');
    exit;
}

// Kiểm tra nếu session đã hết hạn
if (SessionManager::isExpired()) {
    SessionManager::clear();
    header('Location: public/signin.php');
    exit;
}

// Xử lý yêu cầu gửi lại mã
if (isset($_GET['resend']) && $_GET['resend'] == 1) {
    // Xóa mã cũ nếu có
    unset($_SESSION['2fa_code']);
    unset($_SESSION['2fa_expires']);
    
    // Hiển thị thông báo
    $_SESSION['success'] = "Đã gửi lại mã xác thực mới.";
    
    // Chuyển hướng để tránh gửi lại khi refresh
    header('Location: public/two-factor.php');
    exit;
}

// Generate and send 2FA code if not already sent
if (!isset($_SESSION['2fa_code'])) {
    $code = rand(100000, 999999);
    $_SESSION['2fa_code'] = $code;
    $_SESSION['2fa_expires'] = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    
    // Đồng bộ múi giờ với MySQL
    mysqli_query($conn, "SET time_zone = '+07:00'");
    
    $mailer = new Mailer();
    $mailer->sendTwoFactorCode($_SESSION['user_email'], $code);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = $_POST['code'] ?? '';
    
    if ($enteredCode == $_SESSION['2fa_code']) {
        if (strtotime($_SESSION['2fa_expires']) > time()) {
            // Lấy thông tin người dùng từ database
            $user_id = $_SESSION['user_id'];
            $user_query = "SELECT * FROM users WHERE id = '$user_id'";
            $user_result = mysqli_query($conn, $user_query);
            
            if ($user_result && mysqli_num_rows($user_result) > 0) {
                $user = mysqli_fetch_assoc($user_result);
                
                // Thiết lập session cho người dùng
                $_SESSION['user-id'] = $user['id'];
                $_SESSION['user-email'] = $user['email'];
                $_SESSION['user-username'] = $user['username'];
                $_SESSION['user-avatar'] = $user['avatar'];
                
                // Thiết lập session nếu user là admin
                if ($user['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                
                // Đánh dấu đã xác thực 2FA
                $_SESSION['2fa_verified'] = true;
                
                // Xóa mã 2FA
                unset($_SESSION['2fa_code']);
                unset($_SESSION['2fa_expires']);
                
                // Chuyển hướng đến trang dashboard
                if (isset($_SESSION['user_is_admin'])) {
                    header('Location: ' . ROOT_URL . 'admin/');
                } else {
                    header('Location: ' . ROOT_URL . 'dashboard/');
                }
                exit;
            }
        } else {
            $_SESSION['error'] = "Mã xác thực đã hết hạn";
            unset($_SESSION['2fa_code']);
            unset($_SESSION['2fa_expires']);
            header('Location: public/two-factor.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Mã xác thực không hợp lệ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Two-Factor Authentication</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert__message success">
                    <p><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
                </div>
            <?php endif; ?>
            
            <p>Chúng tôi đã gửi mã xác thực đến email của bạn. Vui lòng nhập mã vào ô bên dưới:</p>
            
            <form method="POST" action="<?= ROOT_URL ?>public/two-factor.php">
                <div class="form__control">
                    <input type="text" name="code" placeholder="Nhập mã 6 chữ số" required maxlength="6" pattern="[0-9]{6}">
                </div>
                
                <button type="submit" class="btn">Xác thực</button>
            </form>
            
            <p>Không nhận được mã? <a href="<?= ROOT_URL ?>public/two-factor.php?resend=1">Gửi lại</a></p>
        </div>
    </section>
</body>
</html>