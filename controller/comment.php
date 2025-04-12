<?php
include '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user-id'] ?? null; // Corrected session key to 'user-id'

    if (!$user_id) {
        error_log('Error: User is not logged in.');
        $_SESSION['error'] = 'You must be logged in to comment.';
        header('Location: ../public/post.php?id=' . $post_id);
        exit;
    }

    if (!empty($content)) {
        $query = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('iis', $post_id, $user_id, $content);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Comment added successfully!';
            } else {
                error_log('Error executing query: ' . $stmt->error);
                $_SESSION['error'] = 'Failed to add comment. Please try again.';
            }

            $stmt->close();
        } else {
            error_log('Error preparing query: ' . $conn->error);
            $_SESSION['error'] = 'Failed to prepare the comment query.';
        }
    } else {
        $_SESSION['error'] = 'Comment content cannot be empty.';
    }

    header('Location: ../public/post.php?id=' . $post_id);
    exit;
} else {
    header('Location: ../public/index.php');
    exit;
}