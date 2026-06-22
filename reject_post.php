<?php
include 'db_connect.php';

$id = $_POST['id'];
$reason = $_POST['reason'];

$sql = "UPDATE posts 
        SET status='rejected', rejection_reason='$reason' 
        WHERE post_id='$id'";

mysqli_query($conn, $sql);

header("Location: admin_dashboard.php");
?>