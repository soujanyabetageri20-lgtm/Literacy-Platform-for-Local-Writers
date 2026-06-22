<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    echo "not_logged_in";
    exit();
}

$user_id = $_SESSION['user_id'];

// SAFE INPUT CHECK
$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : null;

if(empty($post_id) || empty($comment)){
    echo "empty_data";
    exit();
}

// INSERT
$sql = "INSERT INTO comments (post_id, user_id, comment_text)
        VALUES ('$post_id', '$user_id', '$comment')";

if(mysqli_query($conn, $sql)){
    echo "success";
} else {
    echo "db_error";
}
?>