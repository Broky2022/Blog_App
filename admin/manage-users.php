<?php
include 'shares/header.php';

//fetch all users from database
$current_admin_id = $_SESSION['user-id'];
if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}
$query = "SELECT * FROM users WHERE NOT id = $current_admin_id";
$users = mysqli_query($conn, $query);
?>

<section class="dashboard">
    <!-- thông báo thêm người dùng thành công -->
    <?php if (isset($_SESSION['add-user-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
        <!-- thông báo sửa người dùng thành công -->
        <?php elseif (isset($_SESSION['edit-user-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
        <!-- thông báo sửa người dùng lỗi -->
        <?php elseif (isset($_SESSION['edit-user-error'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['edit-user-errors'];
                unset($_SESSION['edit-user-error']);
                ?>
            </p>
        </div>
        <!-- thông báo xóa người dùng thành công -->
        <?php elseif (isset($_SESSION['delete-user-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>
        <!-- thông báo xóa người dùng không được -->
        <?php elseif (isset($_SESSION['delete-user-error'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['delete-user-errors'];
                unset($_SESSION['delete-user-error']);
                ?>
            </p>
        </div>
    <?php endif; ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>

        <aside>
            <ul>
                <li>
                    <a href="add-post.php"><i class="uil uil-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="add-user.php"><i class="uil uil-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-edit"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <?php if (mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['lastname']} {$user['firstname']}" ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>controller/delete-user-controller.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                        <td><?php echo $user['is_admin'] ? '✅' : '❌' ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message error"><?= "không có người dùng nào đc tìm thấy!" ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php
include '../shares/footer.php';
?>