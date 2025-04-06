<?php
include 'shares/header.php';

// lấy thông tin category từ database
$query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $query);
if (!$categories) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// lấy lại thông tin đã nhập trong form khi bị lỗi
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

// Xóa thông tin đã nhập trong form
unset($_SESSION['add-post-data']);
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Add Post</h2>
    <!-- hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_SESSION['add-post-error'])) : ?>
      <div class="alert__message error">
        <p>
          <?= $_SESSION['add-post-error'];
          unset($_SESSION['add-post-error']); ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>controller/addpost-controller.php" enctype="multipart/form-data" method="POST">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title" />
      <select name ="category">
        <!-- in ra danh sách category từ database -->
        <?php while($category = mysqli_fetch_assoc($categories)) : ?>
        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile; ?>
      </select>
      <textarea rows="10" name ="body" placeholder="Body"><?= $body ?></textarea>
      <?php if(isset($_SESSION['user_is_admin'])) : ?>
      <div class="form__control inline">
        <input type="checkbox" name ="is_featured" value="1" id="is_featured" checked>
        <label for="is_featured">Featured</label>
      </div>
      <?php endif; ?>
      <div class="form__control">
        <label for="thumbnail">Add Thumbnail</label>
        <input type="file" name ="thumbnail" id="thumbnail">
      </div>
      <button type="submit" name ="submit" class="btn">Add Post</button>
    </form>
  </div>
</section>

<?php
include '../shares/footer.php';
?>