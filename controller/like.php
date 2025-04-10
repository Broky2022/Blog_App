<?php
session_start();
include '../config/database.php';

if (isset($_POST['post_id']) && isset($_SESSION['user-id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user-id'];

    // Kiểm tra xem user đã like bài viết này chưa
    $check_query = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu đã like thì unlike
        $delete_query = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
        mysqli_query($conn, $delete_query);
        echo "unliked";
    } else {
        // Nếu chưa like thì like
        $insert_query = "INSERT INTO likes (post_id, user_id, created_at) VALUES ($post_id, $user_id, NOW())";
        mysqli_query($conn, $insert_query);
        echo "liked";
    }
}
?> 