<?php
include 'shares/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_assoc($result);
} else {
    header('location:' . ROOT_URL . 'admin/manage-categories.php');
    exit;
}
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit category</h2>
    <form action="<?= ROOT_URL ?>controller/edit-category-controller.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $categories['id'] ?>" />
      <input type="text" name="title" value="<?= $categories['title'] ?>" placeholder="title" />
      <input type="text" name="description" value="<?= $categories['description'] ?>" placeholder="description" />
      <button type="submit" name="submit" class="btn">Update category</button>
    </form>
  </div>
</section>

<?php
include '../shares/footer.php';
?>