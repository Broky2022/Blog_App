<?php
require 'config/database.php';

if (isset($_SESSION['user-id'])) {
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $user_query = "SELECT avatar FROM users WHERE id = $id";
  $result = mysqli_query($conn, $user_query);
  $avatar = mysqli_fetch_assoc($result)['avatar'];
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang web tin tức</title>
  <link rel="stylesheet" href="<?= ROOT_URL ?>/css/style.css" />
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
</head>

<body>
  <nav>
    <div class="container nav__container">
      <a href="<?= ROOT_URL ?>" class="nav__logo">Blog Web</a>
      <ul class="nav__items">
        <li class="nav__item">
          <a href="<?= ROOT_URL ?>blog.php" class="nav__link">Blog</a>
        </li>
        <li class="nav__item">
          <a href="<?= ROOT_URL ?>about.php" class="nav__link">About</a>
        </li>
        <li class="nav__item">
          <a href="<?= ROOT_URL ?>services.php" class="nav__link">Services</a>
        </li>
        <li class="nav__item">
          <a href="<?= ROOT_URL ?>contact.php" class="nav__link">Contact</a>
        </li>
        <?php
        if (isset($_SESSION['user-id'])) : ?>
          <li class="nav__profile">
            <div class="avatar">
              <img src="<?= ROOT_URL . 'images/' . $avatar ?>" alt="Avatar" />
            </div>
            <ul>
              <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
              <li><a href="<?= ROOT_URL ?>logout.php">Sign Out</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li class="nav__item"><a href="<?= ROOT_URL ?>signin.php" class="nav__link">Sign In</a></li>
        <?php endif; ?>
      </ul>
      <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
      <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
  </nav>