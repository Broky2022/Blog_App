<?php
require '../shares/header.php';

// Check if the user is logged in
if (!isset($_SESSION['user-id'])) {
  header('location: ' . ROOT_URL . 'signin.php');
  exit;
}
?>