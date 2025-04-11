<?php
include __DIR__ . '/../shares/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);

    // Lấy số lượng like cho bài viết
    $like_query = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = $id";
    $like_result = mysqli_query($conn, $like_query);
    $like_count = mysqli_fetch_assoc($like_result)['like_count'];
} else {
    header('location: ' . ROOT_URL);
    die();
}
?>

<section class="singlepost">
    <div class="container singlepost__container">
        <div class="post-header">
            <h2><?= $post['title'] ?></h2>
            <div class="like-section">
                <button class="like-btn" data-post-id="<?= $post['id'] ?>">
                    <div class="heart-container">
                        <i class="fas fa-heart"></i>
                        <span class="like-count"><?= $like_count ?></span>
                    </div>
                </button>
            </div>
        </div>
        <div class="post__author">
            <?php
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($conn, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post__author-avatar">
                <img src="../images/<?= $author['avatar'] ?>" />
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="../images/<?= $post['thumbnail'] ?>" />
        </div>
        <p><?= $post['body'] ?></p>
    </div>
</section>

<style>
.post-header {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.post-header h2 {
    margin: 0;
    flex: 1;
    padding-right: 1rem;
}

.like-section {
    position: relative;
}

.like-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
}

.heart-container {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.heart-container i {
    font-size: 1.8rem;
    color: #666;
    transition: all 0.3s ease;
}

.like-count {
    font-size: 1.2rem;
    font-weight: bold;
    color: #666;
}

.like-btn:hover .heart-container i,
.like-btn.liked .heart-container i {
    color: #ff4757;
    transform: scale(1.1);
}

.like-btn.liked .heart-container i {
    animation: heartBeat 0.3s ease;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButton = document.querySelector('.like-btn');
    
    likeButton.addEventListener('click', function() {
        const postId = this.dataset.postId;
        const likeCount = this.querySelector('.like-count');
        
        fetch('../controller/like.php', {
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
</script>

<?php
include __DIR__ . '/../shares/footer.php';
?>