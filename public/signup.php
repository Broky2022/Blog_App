<?php
include __DIR__ . '/../config/constains.php';
include __DIR__ . '/../config/google-oauth.php';
// Check for signup errors
$signup_error = $_SESSION['signup'] ?? null;

// lấy lại thông tin đã nhập trong form
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//$avatar = $_SESSION['signup-data']['avatar'] ?? null;

// Xóa thông tin đã nhập trong form
unset($_SESSION['signup-data']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký</title>
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>


<body>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Sign Up</h2>
      <?php if ($signup_error) : ?>
        <div class="alert__message error">
          <p>
            <?= $signup_error;
            unset($_SESSION['signup']);
            ?>
          </p>
        </div>
      <?php endif; ?>
      <form action="<?= ROOT_URL ?>controller/signup-controller.php" enctype="multipart/form-data" method="POST">
        <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
        <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
        <input type="text" name="username" value="<?= $username ?>" placeholder="Username" />
        <input type="email" name="email" value="<?= $email ?>" placeholder="Email" />
        <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password" />
        <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" />
        <div class="form__control">
          <label for="avatar">User Avatar</label>
          <input type="file" name="avatar" id="avatar" />
        </div>
        <button type="submit" name="submit" class="btn">Sign Up</button>
        <div class="form__social">
          <a href="<?= $auth_url ?>" class="btn google">
            <i class="uil uil-google"></i> Sign up with Google
          </a>
        </div>
        <small>Already have an account? <a href="signin.php">Sign In</a></small>
      </form>
    </div>
  </section>
</body>

</html>