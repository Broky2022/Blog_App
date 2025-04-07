<?php
include 'shares/header.php';

// lấy thông tin category từ database
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $category_query);

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id = $id";
  $result = mysqli_query($conn, $query);
  $post = mysqli_fetch_assoc($result);
} else {
  header('location:' . ROOT_URL . 'admin/');
  exit;
}
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit Post</h2>
    <form action="<?= ROOT_URL ?>controller/edit-post-controller.php" enctype="multipart/form-data" method = "POST">
      <input type="hidden" name="id" value="<?= $post['id'] ?>"/>
      <input type="hidden" name="previous_thumbnail" value="<?= $post['thumbnail'] ?>"/>
      <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title" />
      <select name="category">
        <?php while($category = mysqli_fetch_assoc($categories)) : ?>
        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
        <?php endwhile; ?>
      </select>
      <textarea rows="10" name = "body" placeholder="Body"><?= $post['body'] ?></textarea>
      <div class="form__control inline">
        <input type="checkbox" id="is_featured" name = "is_featured" value="1" checked>
        <label for="is_featured">Featured</label>
      </div>
      <div class="form__control">
        <label for="thumbnail">Change Thumbnail</label>
        <input type="file" name = "thumbnail" id="thumbnail">
      </div>
      <button type="submit" name = "submit" class="btn">Update Post</button>
    </form>
  </div>
</section>

<?php
include '../shares/footer.php';
?>