<?php
include __DIR__ . '/../config/constains.php';
include __DIR__ . '/../config/google-oauth.php';
require_once __DIR__ . '/../config/session-manager.php';

// Khởi tạo session với thời hạn 30 phút
SessionManager::start(1800);

$username_email = $_SESSION['signin-data']['username/email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Sign In</h2>
      <?php if (isset($_SESSION['signup-success'])): ?>
        <div class="alert__message success">
          <p><?= $_SESSION['signup-success'];
              unset($_SESSION['signup-success']);
              ?>
          </p>
        </div>
      <?php elseif (isset($_SESSION['signin'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['signin'];
              unset($_SESSION['signin']);
              ?>
          </p>
        </div>
      <?php endif; ?>
      <form action="<?= ROOT_URL ?>controller/signin-controller.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="username/email" value="<?= $username_email ?>" placeholder="Username or Email" />
        <input type="password" name="password" value="<?= $password ?>" placeholder="Password" />
        <button type="submit" name="submit" class="btn">Sign In</button>
        <div class="form__social">
          <a href="<?= $auth_url ?>" class="btn google">
            <i class="uil uil-google"></i> Sign in with Google
          </a>
        </div>
        <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
        <small><a href="forgot-password.php">Forgot Password?</a></small>
      </form>
    </div> 
  </section>
</body>

</html>