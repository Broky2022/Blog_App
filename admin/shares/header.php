<?php
require '../shares/header.php';

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
  header('location: ' . ROOT_URL . 'signin.php');
  exit;
}
// if (!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true) {
//   header('location: ' . ROOT_URL . 'index.php');
//   exit;
// }
?>