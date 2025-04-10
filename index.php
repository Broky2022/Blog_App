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

        // Lấy số lượng like cho bài viết featured
        $like_query = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = " . $featured['id'];
        $like_result = mysqli_query($conn, $like_query);
        $like_count = mysqli_fetch_assoc($like_result)['like_count'];
        ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <span class="like-count"><?= $like_count ?> <i class="fas fa-heart"></i></span>

        <h2 class="post__title">
          <a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
        </h2>
        <p class="post_body">
          <?= substr($featured['body'], 0, 300) ?><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"> - xem thêm</a>
        </p>
        <div class="post__author">
          <!-- lấy thông tin tác giả bằng id-->
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
        <img src="./images/<?= $featured['thumbnail'] ?> " />
      </div>
    </div>
  </section>
<?php endif ?>

<section class="posts <?= $featured ? 'posts__extra-margin' : 'section__extra-margin' ?>">
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

          // Lấy số lượng like cho mỗi bài viết
          $like_query = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = " . $post['id'];
          $like_result = mysqli_query($conn, $like_query);
          $like_count = mysqli_fetch_assoc($like_result)['like_count'];
          ?>
          <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
          <span class="like-count"><?= $like_count ?> <i class="fas fa-heart"></i></span>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const likeCount = this.querySelector('.like-count');
            
            fetch('controller/like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + postId
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'liked') {
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                    this.classList.add('liked');
                } else if (result === 'unliked') {
                    likeCount.textContent = parseInt(likeCount.textContent) - 1;
                    this.classList.remove('liked');
                }
            });
        });
    });
});
</script>

<style>
.like-section {
    margin-top: 1rem;
}

.like-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
    color: #666;
    transition: color 0.3s;
}

.like-btn:hover {
    color: #ff4757;
}

.like-btn.liked {
    color: #ff4757;
}

.like-count {
    margin-left: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.like-count i {
    color: #ff4757;
    margin-left: 0.2rem;
}
</style>

<?php
include 'shares/footer.php';
?>