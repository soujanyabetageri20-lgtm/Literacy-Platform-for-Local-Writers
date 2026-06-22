<?php
session_start();
include 'db_connect.php';

$comment_id = $_POST['comment_id'];
$text = $_POST['text'];

mysqli_query($conn, "UPDATE comments 
SET comment_text='$text' 
WHERE comment_id='$comment_id' 
AND user_id='".$_SESSION['user_id']."'");
?>