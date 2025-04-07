<footer>
  <div class="footer__socials">
    <a href="https://youtube.com" target="_blank"><i class="uil uil-youtube"></i></a>
    <a href="https://facebook.com" target="_blank"><i class="uil uil-facebook"></i></a>
    <a href="https://instagram.com" target="_blank"><i class="uil uil-instagram-alt"></i></a>
    <a href="https://twitter.com" target="_blank"><i class="uil uil-twitter"></i></a>
    <a href="https://telegram.com" target="_blank"><i class="uil uil-telegram"></i></a>
  </div>
  <div class="container footer__container">
    <article>
      <h4>Thể loại</h4>
      <?php
      $catequery = "SELECT * FROM categories LIMIT 5";
      $cates = mysqli_query($conn, $catequery);
      ?>
      <?php while ($cate = mysqli_fetch_assoc($cates)) : ?>
        <ul>
          <li><a href="<?= ROOT_URL ?>category-posts.php?id=<?= $cate['id'] ?>"><?= $cate['title'] ?></a></li>
        </ul>
      <?php endwhile ?>
    </article>
    <article>
      <h4>Support</h4>
      <ul>
        <li><a href="">Online support</a></li>
        <li><a href="">Call numbers</a></li>
        <li><a href="">Emails</a></li>
        <li><a href="">Social Support</a></li>
        <li><a href="">Location</a></li>
      </ul>
    </article>
    <article>
      <h4>Blog</h4>
      <ul>
        <li><a href="">Safety</a></li>
        <li><a href="">Repair</a></li>
        <li><a href="">Recent</a></li>
        <li><a href="">Popular</a></li>
        <li><a href="">Thể loại</a></li>
      </ul>
    </article>
    <article>
      <h4>Permalinks</h4>
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Blog</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Services</a></li>
        <li><a href="">Contact</a></li>
      </ul>
    </article>
  </div>
  <div class="footer__copyright">
    <small>Copyright &copy; 2025 EGATOR TUTORIALS</small>
  </div>
</footer>

<script src="<?= ROOT_URL ?>js/main.js"></script>
</body>

</html>