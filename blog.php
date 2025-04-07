<?php
include 'shares/header.php';

if (!$conn) {
  die("Kết nối database thất bại: " . mysqli_connect_error());
}

$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($conn, $query);

$catequery = "SELECT * FROM categories";
$cates = mysqli_query($conn, $catequery);
?>
<section class="search__bar">
  <form class="container search__bar-container" action="search.php" method="GET">
    <div>
      <i class="uil uil-search"></i>
      <input type="search" name="query" placeholder="Search" required />
    </div>
    <button type="submit" class="btn">Go</button>
  </form>
</section>

<section class="posts">
  <div class="container posts_container">
    <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
      <article class="post">
        <div class="post__thumbnail">
          <img src="./images/<?= $post['thumbnail'] ?>" />
        </div>
        <div class="post__infor">
          <!-- lấy thông tin category bằng id-->
          <?php
          $category_id = $post['category_id'];
          $category_query = "SELECT * FROM categories WHERE id = $category_id";
          $category_result = mysqli_query($conn, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          ?>
          <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>

          <!-- nội dung bài viết -->
          <h3 class="post__title">
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
          </h3>
          <p class="post_body">
          <?= substr($post['body'], 0, 150) ?><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"> - xem thêm</a>
          </p>
          <div class="post__author">
            <!-- lấy thông tin tác giả bằng id-->
            <?php
            $user_id = $post['author_id'];
            $user_query = "SELECT * FROM users WHERE id = $user_id";
            $user_result = mysqli_query($conn, $user_query);
            $user = mysqli_fetch_assoc($user_result);
            ?>
            <div class="post__author-avatar">
              <img src="./images/<?= $user['avatar'] ?>" />
            </div>
            <div class="post__author-info">
              <h5>By: <?= $user['lastname'] . ' ' . $user['firstname'] ?></h5>
              <small><?= date(" H:i - d M, Y", strtotime($post['date_time'])) ?></small>
            </div>
          </div>
        </div>
      </article>
    <?php endwhile ?>
  </div>
</section>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php while ($cate = mysqli_fetch_assoc($cates)) : ?>
      <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $cate['id'] ?>" class="category__button"> <?= $cate['title'] ?> </a>
    <?php endwhile ?>
  </div>
</section>
<?php
include 'shares/footer.php';
?>