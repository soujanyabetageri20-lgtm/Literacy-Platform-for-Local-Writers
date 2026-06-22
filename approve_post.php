<?php
include 'db_connect.php';
$id = $_GET['id'];

mysqli_query($conn, "UPDATE posts SET status='approved' WHERE post_id='$id'");
header("Location: admin_dashboard.php");
?>