<?php
session_start();
include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$rating = $_POST['rating'];

// Check if already rated
$check = mysqli_query($conn, 
"SELECT * FROM ratings WHERE user_id='$user_id' AND post_id='$post_id'");

if(mysqli_num_rows($check) > 0){
    // Update rating
    mysqli_query($conn, 
    "UPDATE ratings SET rating='$rating' 
     WHERE user_id='$user_id' AND post_id='$post_id'");
} else {
    // Insert rating
    mysqli_query($conn, 
    "INSERT INTO ratings (post_id, user_id, rating) 
     VALUES ('$post_id','$user_id','$rating')");
}

// Redirect back to post
header("Location: view_post_user.php?id=$post_id");
exit();
?>