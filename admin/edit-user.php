<?php
include 'shares/header.php';

// Lấy dữ liệu người dùng dựa trên ID
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location:' . ROOT_URL . 'admin/manage-users.php');
    exit;
}
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit User</h2>
    <form action="<?= ROOT_URL ?>controller/edit-user-controller.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $user['id'] ?>" />
      <input type="text" name="firstname" value="<?= $user['firstname'] ?>" placeholder="First Name" />
      <input type="text" name="lastname" value="<?= $user['lastname'] ?>" placeholder="Last Name" />
      <select name="userrole">
        <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Author</option>
        <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
      </select>
      <button type="submit" name="submit" class="btn">Update User</button>
    </form>
  </div>
</section>

<?php
include '../shares/footer.php';
?>