<?php
require_once '../config/google-oauth.php';
require_once '../config/constains.php';

// Kiểm tra kết nối database
if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Lấy thông tin người dùng
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $fullname = $google_account_info->name;
        $picture = $google_account_info->picture;
        
        // Tách firstname và lastname
        $name_parts = explode(' ', $fullname);
        $firstname = $name_parts[0];
        $lastname = end($name_parts);
        
        // Tạo username từ email (lấy phần trước @)
        $username = explode('@', $email)[0];
        
        // Tạo mật khẩu ngẫu nhiên
        $password = bin2hex(random_bytes(8));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra xem email đã tồn tại trong database chưa
        $check_user_query = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_prepare($conn, $check_user_query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $check_user_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_user_result) > 0) {
            // Người dùng đã tồn tại, đăng nhập
            $user = mysqli_fetch_assoc($check_user_result);
            $_SESSION['user-id'] = $user['id'];
            $_SESSION['user_is_admin'] = $user['is_admin'];
            header('location: ' . ROOT_URL);
        } else {
            // Tạo tài khoản mới
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, 0)";
            $stmt = mysqli_prepare($conn, $insert_user_query);
            mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $username, $email, $hashed_password, $picture);
            
            if (mysqli_stmt_execute($stmt)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user-id'] = $user_id;
                $_SESSION['user_is_admin'] = 0;
                
                // Gửi email thông báo tài khoản đã được tạo
                $to = $email;
                $subject = "Tài khoản của bạn đã được tạo";
                $message = "Xin chào $firstname $lastname,\n\n";
                $message .= "Tài khoản của bạn đã được tạo thành công.\n";
                $message .= "Thông tin đăng nhập:\n";
                $message .= "Email: $email\n";
                $message .= "Mật khẩu: $password\n\n";
                $message .= "Vui lòng đổi mật khẩu sau khi đăng nhập.\n\n";
                $message .= "Trân trọng,\n";
                $message .= "Admin";
                
                $headers = "From: admin@yourdomain.com\r\n";
                $headers .= "Reply-To: admin@yourdomain.com\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                
                mail($to, $subject, $message, $headers);
                
                header('location: ' . ROOT_URL);
            } else {
                $_SESSION['signin'] = "Đăng ký thất bại. Vui lòng thử lại.";
                header('location: ' . ROOT_URL . 'public/signin.php');
            }
        }
    } catch (Exception $e) {
        $_SESSION['signin'] = "Có lỗi xảy ra: " . $e->getMessage();
        header('location: ' . ROOT_URL . 'public/signin.php');
    }
} else {
    header('location: ' . ROOT_URL . 'public/signin.php');
}
?> 