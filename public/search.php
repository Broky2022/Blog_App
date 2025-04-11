<?php
include __DIR__ . '/../shares/header.php';

if (!$conn) {
  die("Kết nối database thất bại: " . mysqli_connect_error());
}

if (isset($_GET['query'])) {
  $search_query = mysqli_real_escape_string($conn, $_GET['query']);
  $query = "SELECT * FROM posts WHERE title LIKE '%$search_query%' ORDER BY date_time DESC";
  $search_results = mysqli_query($conn, $query);
} else {
  $search_results = [];
}
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

<section class="search__results">
  <div class="container posts_container">
    <?php if (isset($search_results) && mysqli_num_rows($search_results) > 0) : ?>
      <h2>Search Results:</h2>
      <?php while ($post = mysqli_fetch_assoc($search_results)) : ?>
        <article class="post">
          <div class="post__thumbnail">
            <img src="../images/<?= $post['thumbnail'] ?>" />
          </div>
          <div class="post__infor">
            <h3 class="post__title">
              <a href="<?= ROOT_URL ?>public/post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
            </h3>
            <p class="post_body">
              <?= substr($post['body'], 0, 150) ?><a href="<?= ROOT_URL ?>public/post.php?id=<?= $post['id'] ?>"> - xem thêm</a>
            </p>
          </div>
        </article>
      <?php endwhile ?>
    <?php else : ?>
      <p>No results found for "<?= htmlspecialchars($_GET['query'] ?? '') ?>"</p>
    <?php endif ?>
  </div>
</section>

<?php
include __DIR__ . '/../shares/footer.php';
?>