<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/mail.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session-manager.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Khởi tạo session với thời hạn 30 phút
SessionManager::start(1800);

// Thiết lập múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra nếu session đã hết hạn
if (SessionManager::isExpired()) {
    SessionManager::clear();
    $_SESSION['error'] = "Phiên làm việc đã hết hạn. Vui lòng thử lại.";
    header('Location: /Blog_App/public/forgot-password.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address";
        header('Location: /Blog_App/public/forgot-password.php');
        exit;
    }
    
    // Kiểm tra email có tồn tại trong database không
    $email = mysqli_real_escape_string($conn, $email);
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $check_email_query);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        $_SESSION['error'] = "Email address not found";
        header('Location: /Blog_App/public/forgot-password.php');
        exit;
    }
    
    // Generate token
    $token = bin2hex(random_bytes(32));
    
    // Tạo thời gian hết hạn (1 giờ từ thời điểm hiện tại)
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Đồng bộ múi giờ với MySQL
    mysqli_query($conn, "SET time_zone = '+07:00'");
    
    // Lưu token vào database
    $update_query = "UPDATE users SET 
                    reset_token = '$token',
                    reset_token_expires = '$expires'
                    WHERE email = '$email'";
    
    if (!mysqli_query($conn, $update_query)) {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header('Location: /Blog_App/public/forgot-password.php');
        exit;
    }
    
    // Send email
    $mailer = new Mailer();
    if ($mailer->sendPasswordResetEmail($email, $token)) {
        $_SESSION['success'] = "Password reset link has been sent to your email";
    } else {
        $_SESSION['error'] = "Failed to send reset email";
    }
    
    header('Location: /Blog_App/public/forgot-password.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Forgot Password</h2>
            
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
            
            <form method="POST" action="forgot-password.php">
                <div class="form__control">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <button type="submit" class="btn">Send Reset Link</button>
            </form>
            
            <small>Remember your password? <a href="public/signin.php">Sign In</a></small>
        </div>
    </section>
</body>
</html>