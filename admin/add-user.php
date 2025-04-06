<?php
include 'shares/header.php';

// lấy lại thông tin đã nhập trong form khi bị lỗi
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

// Xóa thông tin đã nhập trong form
unset($_SESSION['add-user-data']);
?>

<section class="form__section">
  <div class="container form__section-container">
    <h2>Add User</h2>
    <!-- hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_SESSION['add-user'])) : ?>
      <div class="alert__message error">
        <p>
          <?= $_SESSION['add-user'];
          unset($_SESSION['add-user']); ?>
        </p>
      </div>
    <?php endif; ?>

    <form action="<?= ROOT_URL ?>controller/adduser-controller.php" enctype="multipart/form-data" method="POST">
      <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
      <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
      <input type="text" name="username" value="<?= $username ?>" placeholder="Username" />
      <input type="email" name="email" value="<?= $email ?>" placeholder="Email" />
      <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password" />
      <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" />
      <!-- chỉ có admin mới có thể thêm người dùng admin -->
      <select name="userrole" value="<?= $userrole ?>">
        <option value="0">Author</option>
        <option value="1">Admin</option>
      </select>
      <div class="form__control">
        <label for="avatar">User Avatar</label>
        <input type="file" name="avatar" id="avatar" />
      </div>
      <button type="submit" name="submit" class="btn">Add User</button>
    </form>
  </div>
</section>

<?php
include './shares/footer.php';
?>