<?php
include 'config/constains.php';
// Check for signup errors
$signup_error = $_SESSION['signup'] ?? null;
unset($_SESSION['signup']);
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
      <form action="">
        <input type="text" placeholder="Username or Email" />
        <input type="password" placeholder="Password" />
        <button type="submit" class="btn">Sign In</button>
        <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
      </form>
    </div>
  </section>
</body>

</html>