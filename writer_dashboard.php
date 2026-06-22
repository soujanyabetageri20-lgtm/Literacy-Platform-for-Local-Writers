<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'db_connect.php';

if(!isset($_SESSION['user_id'])){
	header("Location: login.html");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>writer dashboard</title>
	<link rel="stylesheet" href="dashboard.css">
</head>
<body>


<div class="dashboard-container">
<h2>Welcome, Writer</h2>
<div class="dashboard-cards">
<a href="create_post.php" class="card">Create Post</a>
<a href="my_posts.php" class="card">My Posts</a>
<a href="logout.php" class="card logout">Logout</a>
</div>
</div>
</body>
</html>