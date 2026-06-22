<?php
session_start();
include 'db_connect.php';

$user_id = $_GET['user_id'];

/* mark ONLY unread notifications as read */
mysqli_query($conn,
"UPDATE notifications 
 SET status='read'
 WHERE user_id='$user_id' AND status='unread'");

/* redirect based on role */
$res = mysqli_query($conn,
"SELECT role FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($res);

if($user['role'] == 'writer'){
    header("Location: user_dashboard.php");
} else {
    header("Location: user_dashboard.php");
}

exit();
?>