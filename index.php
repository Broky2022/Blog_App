<?php
include 'shares/header.php';

if (!$conn) {
  die("Kết nối database thất bại: " . mysqli_connect_error());
}

$featured_query = "SELECT * FROM posts WHERE is_featured = 1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 6";
$posts = mysqli_query($conn, $query);

$catequery = "SELECT * FROM categories";
$cates = mysqli_query($conn, $catequery);
?>

<?php if (mysqli_num_rows($featured_result) == 1) : ?>
  <section class="featured">
    <div class="container featured__container" style="display: flex;  gap: 2rem;">
      <div class="post__info" style="flex: 1;">
        <!-- lấy thông tin category bằng id-->
        <?php
        $category_id = $featured['category_id'];
        $category_query = "SELECT * FROM categories WHERE id = $category_id";
        $category_result = mysqli_query($conn, $category_query);
        $category = mysqli_fetch_assoc($category_result);
        ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
        <p class="post_body">
          <?= substr($featured['body'], 0, 300) ?><a href="post.php"> - xem thêm</a>
        </p>
        <div class="post__author">
          <!-- lấy thông tin category bằng id-->
          <?php
          $user_id = $featured['author_id'];
          $user_query = "SELECT * FROM users WHERE id = $user_id";
          $user_result = mysqli_query($conn, $user_query);
          $user = mysqli_fetch_assoc($user_result);
          ?>
          <div class="post__author-avatar">
            <img src="./images/<?= $user['avatar'] ?>" />
          </div>
          <div class="post__author-info">
            <h5>By: <?= $user['lastname'] . ' ' . $user['firstname'] ?></h5>
            <small><?= date(" H:i - d M, Y", strtotime($featured['date_time'])) ?></small>
          </div>
        </div>
      </div>
      <div class="post__thumbnail" style="flex: 1;">
        <img src="./images/<?= $featured['thumbnail'] ?>" />
      </div>
    </div>
  </section>
<?php endif ?>



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
          <a href="category-posts.php" class="category__button"><?= $category['title'] ?></a>
          <h3 class="post__title">
            <a href="post.php"><?= $post['title'] ?></a>
          </h3>
          <p class="post_body">
          <?= substr($featured['body'], 0, 100) ?><a href="post.php"> - xem thêm</a>
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
              <small><?= date(" H:i - d M, Y", strtotime($featured['date_time'])) ?></small>
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
      <a href="category-posts.php?id=<?= $cate['id'] ?>" class="category__button"> <?= $cate['title'] ?> </a>
    <?php endwhile ?>
  </div>
</section>

<?php
include 'shares/footer.php';
?>