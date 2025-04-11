<?php
include __DIR__ . '/../shares/header.php';

if (!isset($_GET['id'])) {
    header('location: ' . ROOT_URL . 'public/blog.php');
    exit;
} else {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id = $id ORder by date_time DESC";
    $posts = mysqli_query($conn, $query);
}
?>

<header class="category__title">
    <h2>
        <!-- lấy thông tin category bằng id-->
        <?php
        $category_query = "SELECT * FROM categories WHERE id = $id";
        $category_result = mysqli_query($conn, $category_query);
        $category = mysqli_fetch_assoc($category_result);
        echo $category['title']
        ?>
    </h2>
</header>

<?php if(mysqli_num_rows($posts) == 0) : ?>
    <div class="alert__message error lg">
        <p>Không có bài viết nào trong thể loại này</p>
    </div>
<?php endif; ?>
<section class="posts">
    <div class="container posts_container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="../images/<?= $post['thumbnail'] ?>" />
                </div>
                <div class="post__infor">
                    <!-- nội dung bài viết -->
                    <h3 class="post__title">
                        <a href="<?= ROOT_URL ?>public/post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                    </h3>
                    <p class="post_body">
                        <?= substr($post['body'], 0, 150) ?><a href="<?= ROOT_URL ?>public/post.php?id=<?= $post['id'] ?>"> - xem thêm</a>
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
                            <img src="../images/<?= $user['avatar'] ?>" />
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

<?php
include __DIR__ . '/../shares/footer.php';
?>