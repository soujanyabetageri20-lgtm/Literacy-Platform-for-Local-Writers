<?php
session_start();
include 'db_connect.php';

$comment_id = $_POST['comment_id'];

mysqli_query($conn, "DELETE FROM comments 
WHERE comment_id='$comment_id' 
AND user_id='".$_SESSION['user_id']."'");
?>