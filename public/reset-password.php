<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session-manager.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Khởi tạo session với thời hạn 30 phút
SessionManager::start(1800);

// Thiết lập múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra token
$token = $_GET['token'] ?? '';
if (empty($token)) {
    header('Location: signin.php');
    exit;
}

// Đồng bộ múi giờ với MySQL
mysqli_query($conn, "SET time_zone = '+07:00'");

// Kiểm tra token trong database
$token = mysqli_real_escape_string($conn, $token);
$check_token_query = "SELECT * FROM users WHERE reset_token = '$token' AND reset_token_expires > NOW()";
$result = mysqli_query($conn, $check_token_query);

if (!$result || mysqli_num_rows($result) === 0) {
    $_SESSION['signin'] = "Invalid or expired password reset link.";
    header('Location: signin.php');
    exit;
}

$user = mysqli_fetch_assoc($result);

// Xử lý form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate password
    if (strlen($password) < 8) {
        $_SESSION['reset-error'] = "Password must be at least 8 characters long";
    } elseif ($password !== $confirm_password) {
        $_SESSION['reset-error'] = "Passwords do not match";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password và xóa token
        $user_id = $user['id'];
        $update_query = "UPDATE users SET 
                        password = '$hashed_password',
                        reset_token = NULL,
                        reset_token_expires = NULL
                        WHERE id = $user_id";
        
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['signin'] = "Password has been reset successfully. Please sign in with your new password.";
            header('Location: signin.php');
            exit;
        } else {
            $_SESSION['reset-error'] = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Reset Password</h2>
            
            <?php if (isset($_SESSION['reset-error'])): ?>
                <div class="alert__message error">
                    <p><?= $_SESSION['reset-error']; unset($_SESSION['reset-error']); ?></p>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form__control">
                    <input type="password" name="password" placeholder="New Password" required minlength="8">
                </div>
                <div class="form__control">
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" required minlength="8">
                </div>
                
                <button type="submit" class="btn">Reset Password</button>
            </form>
            
            <small>Remember your password? <a href="public/signin.php">Sign In</a></small>
        </div>
    </section>
</body>
</html> 