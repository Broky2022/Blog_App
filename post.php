<?php
include 'shares/header.php';

if (!isset($_GET['id'])) {
  header('location: ' . ROOT_URL . 'blog.php');
  exit;
} else {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id = $id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    header('location: ' . ROOT_URL . 'blog.php');
    exit;
  } else {
    $post = mysqli_fetch_assoc($result);
  }
}
?>

<section class="singlepost">
  <div class="container singlepost__container">
    <h2><?= $post['title'] ?></h2>
    <div class="post__auther">
      <?php
      $user_id = $post['author_id'];
      $user_query = "SELECT * FROM users WHERE id = $user_id";
      $user_result = mysqli_query($conn, $user_query);
      $user = mysqli_fetch_assoc($user_result);
      ?>
      <div class="post__author-avatar">
        <img src="./images/<?= $user['avatar'] ?>" />
      </div>
      <div class="post__auther-info">

        <h5>By: <?= $user['lastname'] . ' ' . $user['firstname'] ?></h5>
        <small><?= date(" H:i - d M, Y", strtotime($post['date_time'])) ?></small>
      </div>
    </div>
    <div class="singlepost__thumbnail">
      <img src="./images/<?= $post['thumbnail'] ?>" />
    </div>
    <p><?= $post['body'] ?></p>
  </div>
</section>

<?php
include 'shares/footer.php';
?>