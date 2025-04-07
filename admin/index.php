<?php
include 'shares/header.php';

$current_user_id = $_SESSION['user-id'];
if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

// 
$query = "SELECT id, title, category_id FROM posts WHERE author_id = $current_user_id ORDER BY id DESC";
$posts = mysqli_query($conn, $query);
?>

<section class="dashboard">
    <!-- thông báo thêm bài viết thành công -->
    <?php if (isset($_SESSION['add-post-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
        <!-- thông báo sửa bài viết thành công -->
        <?php elseif (isset($_SESSION['edit-category-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
        <!-- thông báo sửa bài viết lỗi -->
        <?php elseif (isset($_SESSION['edit-category-error'])) : ?>
        <div class="alert__message error container">
            <p><?= $_SESSION['edit-category-errors'];
                unset($_SESSION['edit-category-error']);
                ?>
            </p>
        </div>
        <!-- thông báo xóa bài viết thành công -->
        <?php elseif (isset($_SESSION['delete-category-success'])) : ?>
        <div class="alert__message success container">
            <p><?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>
        <!-- thông báo xóa bài viết không được -->
        <?php elseif (isset($_SESSION['delete-category-error'])) : ?>
        <div class="alert__message error container">
            <p><?= $_SESSION['delete-category-errors'];
                unset($_SESSION['delete-category-error']);
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
                    <a href="index.php" class="active"><i class="uil uil-postcard"></i>
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
                        <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-post.php"><i class="uil uil-edit"></i>
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
            <h2>Manage Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- lấy tên category bằng id (có thể dùng câu truy vấn ở trên nhưng lười quá!)-->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id = $category_id";
                            $category_result = mysqli_query($conn, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>controller/delete-post-controller.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "không có bài viết nào đc tìm thấy!" ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php
include '../shares/footer.php';
?>