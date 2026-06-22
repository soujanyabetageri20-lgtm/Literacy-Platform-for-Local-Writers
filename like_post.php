<?php
session_start();
include 'db_connect.php';

// Check login
if(!isset($_SESSION['user_id'])){
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$type = $_POST['type']; // like or dislike

// Check if already reacted
$check = mysqli_query($conn, "SELECT * FROM post_reactions 
WHERE user_id='$user_id' AND post_id='$post_id'");

if(mysqli_num_rows($check) > 0){

    // Update reaction
    mysqli_query($conn, "UPDATE post_reactions 
    SET reaction='$type' 
    WHERE user_id='$user_id' AND post_id='$post_id'");

} else {

    // Insert new reaction
    mysqli_query($conn, "INSERT INTO post_reactions (user_id, post_id, reaction) 
    VALUES ('$user_id', '$post_id', '$type')");
}

// Get updated counts
$likes = mysqli_query($conn, "SELECT COUNT(*) as total FROM post_reactions 
WHERE post_id='$post_id' AND reaction='like'");
$like_count = mysqli_fetch_assoc($likes)['total'];

$dislikes = mysqli_query($conn, "SELECT COUNT(*) as total FROM post_reactions 
WHERE post_id='$post_id' AND reaction='dislike'");
$dislike_count = mysqli_fetch_assoc($dislikes)['total'];

// Return updated counts (AJAX response)
echo json_encode([
    "likes" => $like_count,
    "dislikes" => $dislike_count
]);
?>