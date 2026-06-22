<?php
session_start();
include 'db_connect.php';

// CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

if(isset($_GET['id'])){
    $post_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // DELETE ONLY IF USER OWNS THE POST
    $sql = "DELETE FROM posts WHERE post_id='$post_id' AND author_id='$user_id'";
    
    mysqli_query($conn, $sql);
}

// REDIRECT BACK
header("Location: my_posts1.php");
exit();
?>