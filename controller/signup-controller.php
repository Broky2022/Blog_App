<?php
// signup logic
require '../config/database.php';

// lấy thông tin từ form đăng ký
if (isset($_POST['submit'])) {
    $firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $createpassword = filter_var(trim($_POST['createpassword']), FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmpassword = filter_var(trim($_POST['confirmpassword']), FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //hiển thị thông tin về file được upload
    //var_dump($avatar);

    //kiểm tra xem các trường có rỗng hay không
    //echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;

    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($createpassword) || empty($confirmpassword)) {
        $_SESSION['signup'] = "Vui lòng điền đầy đủ thông tin!";
        // header('location: ' . ROOT_URL . 'signup.php');
        // exit;
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Mật khẩu không được ít hơn 8 ký tự!";
    } elseif (empty($avatar['name'])) {
        $_SESSION['signup'] = "Bạn thiếu ảnh!";
    } else {
        // kiểm tra mật khẩu xác nhận
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Mật khẩu xác nhận không đúng!";
        } else {
            // mã hóa password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            //kiểm tra password mã hóa thành công chưa
            // echo $createpassword . '<br/>';
            // echo $hashed_password;

            // kiểm tra usernam or email có hợp lệ không
            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $user_check_result = mysqli_query($conn, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['signup'] = "Tên đăng nhập hoặc email đã tồn tại!";
            } else {
                //setup tên avt
                $time = time(); //sử dụng thời gian thực làm tên mỗi hình ảnh
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // kiểm tra file có phải là ảnh không
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $ext = explode('.', $avatar_name);
                $ext = end($ext);

                if (in_array($ext, $allowed_files)) {
                    // kiểm tra kích thước file
                    if ($avatar['size'] < 1000000) {
                        // upload file
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = "Kích thước ảnh không được lớn hơn 1MB!";
                    }
                } else {
                    $_SESSION['signup'] = "File không phải là ảnh!";
                }
            }
        }
    }

    // nếu không có lỗi thì thêm người dùng vào database
    if (isset($_SESSION['signup'])) {
        // nếu có lỗi thì chuyển hướng về trang đăng ký
        $_SESSION['signup-data'] = $_POST; // lưu lại thông tin đã nhập
        header('location: ' . ROOT_URL . 'signup.php');
        exit;
    } else {
        // thêm người dùng vào database
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
        $insert_user_result = mysqli_query($conn, $insert_user_query);

        if ($insert_user_result) {
            // đăng nhập người dùng
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['user'] = $username;
            $_SESSION['signup-success'] = "Đăng ký thành công!";
            header('location: ' . ROOT_URL . 'signin.php');
            exit;
        } else {
            $_SESSION['signup'] = "Có lỗi xảy ra trong quá trình đăng ký!";
            header('location: ' . ROOT_URL . 'signup.php');
            exit;
        }

        /*
        if(!mysqli_errno($conn)) {
            // đăng nhập người dùng
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['user'] = $username;
            $_SESSION['signup-success'] = "Đăng ký thành công!";
            header('location: ' . ROOT_URL . 'index.php');
            exit;
        } else {
            $_SESSION['signup'] = "Có lỗi xảy ra trong quá trình đăng ký!";
            header('location: ' . ROOT_URL . 'signup.php');
            exit;
        }
        */
    }
} else {
    // nếu không có thông tin từ form thì chuyển hướng về trang đăng ký
    header('location: ' . ROOT_URL . 'signup.php');
    exit;
}
