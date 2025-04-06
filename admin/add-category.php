<?php
include 'shares/header.php';

// Retrieve previously entered data if there was an error
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

// Clear session data
unset($_SESSION['add-category-data']);
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Add Category</h2>
    <!-- Display error message if any -->
    <?php if (isset($_SESSION['add-category-error'])) : ?>
      <div class="alert__message error">
        <p>
          <?= $_SESSION['add-category-error'];
          unset($_SESSION['add-category-error']); ?>
        </p>
      </div>
    <?php endif; ?>

    <form action="<?= ROOT_URL ?>controller/addcategory-controller.php" method="POST">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title" />
      <textarea name="description" rows="4" placeholder="Description"><?= $description ?></textarea>
      <button type="submit" name="submit" class="btn">Add Category</button>
    </form>
  </div>
</section>

<?php
include '../shares/footer.php';
?>