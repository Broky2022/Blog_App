<?php
include 'shares/header.php';
?>
<section class="search__bar">
  <form class="container search__bar-container" action="">
    <div>
      <i class="uil uil-search"></i>
      <input type="search" name="" placeholder="Search" />
    </div>
    <button type="submit" class="btn">Go</button>
  </form>
</section>

<section class="posts">
  <div class="container posts_container">
    <article class="post">
      <div class="post__thumbnail">
        <img src="./images/02.jpg" />
      </div>
      <div class="post__infor">
        <a href="" class="category__button">Wild Life</a>
        <h3 class="post__title">
          <a href="post.html">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim,
            tempore.</a>
        </h3>
        <p class="post_body">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex
          laboriosam culpa iste doloremque atque.
        </p>
        <div class="post__author">
          <div class="post__author-avatar">
            <img src="images/04.png" />
          </div>
          <div class="post__author-info">
            <h5>By: Mr. John Wick</h5>
            <small>23 years ago</small>
          </div>
        </div>
      </div>
    </article>
    <article class="post">
      <div class="post__thumbnail">
        <img src="./images/03.png" />
      </div>
      <div class="post__infor">
        <a href="" class="category__button">Wild Life</a>
        <h3 class="post__title">
          <a href="post.html">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim,
            tempore.</a>
        </h3>
        <p class="post_body">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex
          laboriosam culpa iste doloremque atque.
        </p>
        <div class="post__author">
          <div class="post__author-avatar">
            <img src="images/01.jpg" />
          </div>
          <div class="post__author-info">
            <h5>By: Mr. John Wick</h5>
            <small>23 years ago</small>
          </div>
        </div>
      </div>
    </article>
    <article class="post">
      <div class="post__thumbnail">
        <img src="./images/04.png" />
      </div>
      <div class="post__infor">
        <a href="" class="category__button">Wild Life</a>
        <h3 class="post__title">
          <a href="post.html">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim,
            tempore.</a>
        </h3>
        <p class="post_body">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex
          laboriosam culpa iste doloremque atque.
        </p>
        <div class="post__author">
          <div class="post__author-avatar">
            <img src="images/01.jpg" />
          </div>
          <div class="post__author-info">
            <h5>By: Mr. John Wick</h5>
            <small>23 years ago</small>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <a href="" class="category__button">Đồ ăn</a>
    <a href="" class="category__button">Âm nhạc</a>
    <a href="" class="category__button">Giải trí</a>
    <a href="" class="category__button">Thể thao</a>
    <a href="" class="category__button">Điện tử</a>
    <a href="" class="category__button">Khoa học</a>
  </div>
</section>
<?php
include 'shares/footer.php';
?>